<?php

namespace App\Http\Controllers\Staff;

use App\Action\Group\Group;
use App\Action\PlayerHistory\PlayerHistory;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMission;
use Carbon\Carbon;
use Cog\Laravel\Ban\Models\Ban;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class ApiManageUserController extends Controller
{
    public function list(Request $request, Group $group): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $step = $request->get('step', 0);
            $limit = $request->get('limit', 20);
            $q = $request->get('query', []);

            if ($limit < 1 || $limit > 60) $limit = 20;

            $keys = [];
            $items = [];

            $query = User::leftJoin('user_missions', function($join) {
                $join->on('user_missions.user_id', '=', 'users.id')->on('user_missions.id', '=', DB::raw("(SELECT max(id) FROM user_missions WHERE user_missions.user_id = users.id AND user_missions.attended_at IS NOT NULL)"));
            })->leftJoin('user_groups', function ($join) {
                $join->on('user_groups.user_id', '=', 'users.id')
                    ->on('user_groups.group_id', '=', DB::raw("(select max(group_id) FROM user_groups WHERE user_groups.user_id = users.id AND user_groups.deleted_at IS NULL)"))
                    ->on('user_groups.id', '=', DB::raw("(select max(id) FROM user_groups WHERE user_groups.user_id = users.id AND user_groups.deleted_at IS NULL)"));
            });

            $query =  $query->whereNotNull('users.agreed_at');

            if (!empty($q['filter'])) {
                switch ($q['filter']) {
                    case '신규가입 미참여':
                        $query = $query->whereNull('user_missions.attended_at')->whereDate('users.created_at', '>=', now()->subDays(14));
                        break;
                    case '30일이상 미참여':
                        $query = $query->whereNotNull('user_missions.attended_at')->whereDate('user_missions.attended_at', '>=', now()->subDays(30));
                        break;
                }
            }

            if (!empty($q['group'])) {
                $query = $query->where('user_groups.group_id', '=', $q['group']);
            }

            $query = $query->select(['users.id', 'users.nickname', 'users.visited_at', 'users.visit', 'users.created_at', 'user_missions.attended_at', 'user_groups.group_id']);

            if (!empty($q['order'])) {
                switch ($q['order']) {
                    case '가입일 오른차순':
                        $query = $query->oldest('created_at');
                    break;
                    case '가입일 내림차순':
                        $query = $query->latest('created_at');
                        break;
                    case '방문일 오른차순':
                        $query = $query->oldest('visited_at');
                        break;
                    case '방문일 내림차순':
                        $query = $query->latest('visited_at');
                        break;
                    case '방문 오른차순':
                        $query = $query->orderBy('visit', 'asc');
                        break;
                    case '방문 내림차순':
                        $query = $query->orderBy('visit', 'desc');
                        break;
                    case '미션 참가일 오른차순':
                        $query = $query->oldest('attended_at');
                        break;
                    case '미션 참가일 내림차순':
                        $query = $query->latest('attended_at');
                        break;
                }
            }

            $countUser = $query->count();
            $step = $this->getPaginationStep($step, $limit, $countUser);

            $query = $query->offset($step * $limit)->limit($limit);
            $rows = $query->get();

            foreach ($rows as $row) {
                $ban = Ban::where('bannable_id', '=', $row->id)->latest()->first();

                $keys[] = $row->id;
                $items[] = [
                    $row->nickname,
                    $group->getName($row->group_id),
                    is_null($ban) ? '⨉' : (is_null($ban->expired_at) ? '무기한' : $ban->expired_at->toDateString()),
                    $row->created_at->toDateString(),
                    $row->visited_at->toDateString(),
                    is_null($row->attended_at) ? '⨉' : Carbon::createFromFormat('Y-m-d H:i:s', $row->attended_at)->toDateString(),
                    UserMission::whereNotNull('attended_at')->where('user_id', $row->id)->count(),
                    "<a class='text-indigo-600 hover:text-indigo-900' href='". route('staff.user.all.read', $row->id) ."'>확인하기</a>"
                ];
            }

            return $this->jsonResponse(200, 'OK', [
                'fields' => ['닉네임', '등급', '활동 정지', '가입', '최근 방문', '최근 미션 참가', '미션 참가', '상세 정보'],
                'keys' => $keys,
                'items' => $items,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => $countUser
                ]
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function process(Request $request, Group $group, PlayerHistory $history): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'type' => 'string|required',
                'user_id' => 'array|required',
                'query' => 'array',
                'reason' => ''
            ]);

            if (count($request->get('user_id')) <= 0) {
                throw new Exception('USER NOT SELECTED', 422);
            }

            $executor = $request->user();
            $users = User::whereNotNull('agreed_at')->whereIn('id', $request->get('user_id'))->get();
            $reason = strip_tags($request->get('reason', ''));
            $q = $request->get('query');

            switch ($request->get('type')) {
                case 'ban':
                    $users->each(function ($i, $k) use ($history, $executor, $reason, $q) {
                        $b = ['comment' => $reason];

                        if (!empty($q['days'])) {
                            $b['expired_at'] = now()->addDays((int) $q['days']);
                        }

                        if ($i->isBanned()) {
                            $i->unban();
                        }

                        $i->ban($b);
                        $history->add($history->getIdentifierFromUser($i), $history::TYPE_USER_BANNED, $reason, $executor);
                    });
                    break;
                case 'unban':
                    $users->each(function ($i, $k) use ($history, $executor, $reason) {
                        if ($i->isBanned()) {
                            $history->add($history->getIdentifierFromUser($i), $history::TYPE_USER_UNBANNED, $reason, $executor);
                            $i->unban();
                        }
                    });
                    break;
                case 'group':
                    if (empty($q['group'])) {
                        throw new Exception('GROUP ID EMPTY', 422);
                    }

                    $users->each(function ($i, $k) use ($group, $history, $executor, $reason, $q) {
                        $group_id = (int) $q['group'];

                        if (!$group->has($group_id)) {
                            $group->getUserGroups($i)->each(function ($ii, $kk) {
                                $ii->delete();
                            });

                            $group->add($group_id, $i, $reason, $executor);
                        }
                    });
                    break;
            }


            return $this->jsonResponse(200, 'OK', []);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}
