<?php

namespace App\Http\Controllers\Staff;

use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMission;
use Carbon\Carbon;
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
            $limit = $request->get('limit', 25);

            $q = ['group' => '', 'term' => '', 'order' => ''];
            $q = array_merge($q, $request->get('query', []));

            if ($limit < 1 || $limit > 150) $limit = 25;

            $keys = [];
            $items = [];

            $query =  User::whereNotNull('agreed_at');

            $query = $query->leftJoin('user_missions', function($join) {
                $join->on('user_missions.user_id', '=', 'users.id')->on('user_missions.id', '=', DB::raw("(select max(id) from user_missions WHERE user_missions.user_id = users.id AND user_missions.attended_at IS NOT NULL)"));
            })->leftJoin('user_groups', function ($join) {
                $join->on('user_groups.user_id', '=', 'users.id')->on('user_groups.group_id', '=', DB::raw("(select max(group_id) from user_groups WHERE user_groups.user_id = users.id AND user_groups.deleted_at IS NULL)"));
            });

            if (!empty($q['group'])) {
                $query = $query->where('user_groups.group_id', '=', $q['group']);
            }

            /*
            if (!empty($q['term'])) {
                $now = now();

                switch ($q['term']) {
                    case '1일':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subDay());
                        break;
                    case '3일':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subDays(3));
                        break;
                    case '1주':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subWeek());
                        break;
                    case '2주':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subWeeks(2));
                        break;
                    case '1개월':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subMonth());
                        break;
                    case '3개월':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subMonths(3));
                        break;
                    case '6개월':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subMonths(6));
                        break;
                    case '1년':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subYear());
                        break;
                    case '3년':
                        $query = $query->whereDate('created_at', '>=', $now->copy()->subYears(3));
                        break;
                }
            }
            */

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
              $keys[] = $row->id;
              $items[] = [
                  $row->nickname,
                  $group->getName($row->group_id),
                  $row->created_at->toDateString(),
                  $row->visited_at->toDateString(),
                  is_null($row->attended_at) ? '' : Carbon::createFromFormat('Y-m-d H:i:s', $row->attended_at)->toDateString(),
                  UserMission::whereNotNull('attended_at')->where('user_id', $row->id)->count(),
                  "<a class='text-indigo-600 hover:text-indigo-900' href='". route('staff.user.all.read', $row->id) ."' target='_blank'>확인하기</a>"
              ];
            }

            return $this->jsonResponse(200, 'OK', [
                'fields' => ['닉네임', '회원 등급', '가입일', '최근 방문일', '최근 미션 참가일', '미션 참가', '상세 정보'],
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
}
