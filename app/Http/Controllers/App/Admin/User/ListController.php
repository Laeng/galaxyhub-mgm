<?php

namespace App\Http\Controllers\App\Admin\User;

use App\Enums\BanCommentType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Ban\Interfaces\BanRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Contracts\UserServiceContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->userRepository = $user;
    }

    public function index(): View
    {
        return view('app.admin.user.index', [
            'groups' => RoleType::getKoreanNames(),

        ]);
    }

    public function list
    (
        Request $request, BanRepositoryInterface $banRepository,
        UserAccountRepositoryInterface $userAccountRepository, UserMissionRepositoryInterface $userMissionRepository
    ): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $count = $this->userRepository->count();

            $limit = $request->get('limit', 20);
            $step = $this->getPaginationStep($request->get('step', 0), $limit, $count);
            $q = $request->get('query', []);

            if ($limit < 1 || $limit > 100) $limit = 20;

            $query = $this->userRepository->new()->newQuery()->leftJoin('user_missions', function ($join) {
                $join->on('user_missions.id', '=', DB::raw("(SELECT max(user_missions.id) FROM user_missions WHERE user_missions.user_id = users.id)"));
                    // OLD
                    //->on('user_missions.user_id', '=', 'users.id')
                    //->on('user_missions.id', '=', DB::raw("(SELECT max(id) FROM user_missions WHERE user_missions.user_id = users.id AND user_missions.attended_at IS NOT NULL)"));
            });

            if (!empty($q['filter']) && $q['filter'] !== '예비 가입자')
            {
                $query = $query->whereNull('users.agreed_at');
            }
            else
            {
                $query = $query->whereNotNull('users.agreed_at');
            }

            if (!empty($q['find']))
            {
                switch ($q['find'])
                {
                    case 'id64':
                        $id = array_unique(array_column($userAccountRepository->findByAccountId('steam', $q['find_id'], ['user_id'])->toArray(), 'user_id'));
                        $query->whereIn('users.id', $id);
                        break;
                    case 'nickname':
                        $id = array_unique(array_column($userAccountRepository->findByNickname($q['find_id'], ['user_id'])->toArray(), 'user_id'));
                        $query->whereIn('users.id', $id);
                        break;
                }
            }

            if (!empty($q['filter']))
            {
                switch ($q['filter'])
                {
                    case '신규가입 미참여':
                        $query = $query->whereNull('user_missions.attended_at')->whereDate('users.agreed_at', '<=', now()->subDays(30));
                        break;
                    case '30일이상 미참여':
                        $query = $query->whereNotNull('user_missions.attended_at')->whereDate('user_missions.attended_at', '<=', now()->subDays(30));
                        break;
                    case '활동 정지 회원':
                        $query = $query->whereNotNull('banned_at');
                        break;
                }
            }

            if (!empty($q['group'])) {
                $query = $query->role($q['group']);
            }

            $query = $query->select(['users.id', 'users.name', 'users.visited_at', 'users.visit', 'users.created_at', 'user_missions.attended_at']);

            if (!empty($q['order']))
            {
                switch ($q['order'])
                {
                    case '가입일 오른차순':
                        $query = $query->oldest('agreed_at');
                        break;
                    case '가입일 내림차순':
                        $query = $query->latest('agreed_at');
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

            $count = $query->count();

            if ($count > 0)
            {
                $users = $query->offset($step * $limit)->limit($limit)->get();

                $th = ['닉네임', '등급', '활동 정지', '가입', '최근 방문', '최근 미션 참가', '미션 참가', '상세 정보'];
                $tr = array();

                foreach ($users as $user)
                {
                    $ban = $banRepository->findByUserId($user->id)->first();

                    $row = [
                        $user->id,
                        $user->name,
                        RoleType::getKoreanNames()[$user->roles()->latest()->first()->name], //TODO repository 패턴 사용하기
                        is_null($ban) ? '⨉' : (is_null($ban->expired_at) ? '무기한' : $ban->expired_at->toDateString()),
                        $user->created_at->toDateString(),
                        $user->visited_at->toDateString(),
                        is_null($user->attended_at) ? '⨉' : Carbon::createFromFormat('Y-m-d H:i:s', $user->attended_at)->toDateString(),
                        "{$userMissionRepository->findAttendedMissionByUserId($user->id)->count()} 회",
                        "<a class='link-indigo' href='". route('admin.user.read', $user->id) ."'>확인하기</a>"
                    ];

                    $tr[] = $row;
                }
            }
            else
            {
                $th = ['조건에 맞는 회원이 없습니다.'];
                $tr = array();
            }


            return $this->jsonResponse(200, 'OK', [
                'checkbox' => true,
                'mobile' => false,
                'name' => 'user_id',
                'th' => $th,
                'tr' => $tr,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => $count
                ]
            ]);

        }
        catch (Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : [
                'checkbox' => true,
                'mobile' => false,
                'name' => 'user_id',
                'th' => [],
                'tr' => [],
                'count' => [
                    'step' => 0,
                    'limit' => 0,
                    'total' => 0
                ]
            ]);
        }
    }

    public function process(Request $request, UserServiceContract $userService, BanRepositoryInterface $banRepository): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'type' => 'string|required',
                'user_id' => 'array|required',
                'query' => 'array',
                'reason' => ''
            ]);

            if (count($request->get('user_id')) <= 0)
            {
                throw new Exception('USER NOT SELECTED', 422);
            }

            $executor = Auth::user();
            $users = $this->userRepository->findByIds($request->get('user_id'));
            $reason = strip_tags($request->get('reason', '변경 사유를 입력하지 않음.'));
            $q = $request->get('query');

            if ($reason === '')
            {
                $reason = '변경 사유를 입력하지 않음.';
            }

            switch ($request->get('type'))
            {
                case 'ban':
                    foreach ($users as $user)
                    {
                        $userService->ban($user->id, $reason, !empty($q['days']) ? $q['days'] : null, $executor->id);
                    }
                    break;

                case 'unban':
                    foreach ($users as $user)
                    {
                        $userService->unban($user->id, $reason, $executor->id);
                    }
                    break;

                case 'group':
                    if (empty($q['group']))
                    {
                        throw new Exception('ROLE EMPTY', 422);
                    }

                    foreach ($users as $user)
                    {
                        if (isset(RoleType::getKoreanNames()[$q['group']]))
                        {
                            $roles = $user->getRoleNames();

                            foreach ($roles as $role) {
                                $user->removeRole($role);
                            }

                            $user->assignRole($q['group']);

                            $userService->createRecord($user->id, UserRecordType::ROLE_DATA->name, [
                                'role' => $q['group'],
                                'comment' => $reason
                            ], $executor->id);
                        } else
                        {
                            throw new Exception('NOT FOUND ROLE', 422);
                        }
                    }
                    break;

                case 'drop':
                    foreach ($users as $user)
                    {
                        $userService->createRecord($user->id, UserRecordType::USER_DELETE->name, [
                            'comment' => $reason
                        ], $executor->id);
                        $userService->delete($user->id);
                    }
                    break;

                default:
                    break;
            }

            return $this->jsonResponse(200, 'OK', []);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}


