<?php

namespace App\Http\Controllers\App\Admin\Application;

use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function config;
use function route;
use function view;

class ListController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->userRepository = $user;
    }

    public function index(Request $request): View
    {
        return view('app.admin.application.index');
    }

    public function list(Request $request, SurveyServiceContract $surveyService, UserAccountRepositoryInterface $accountRepository): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $count = $this->userRepository->findByRole(RoleType::APPLY->name)->count();

            $limit = $request->get('limit', 20);
            $step = $this->getPaginationStep($request->get('step', 0), $limit, $count);

            if ($limit < 1 || $limit > 100) $limit = 20;

            $users = $this->userRepository->findByRoleWithPagination(RoleType::APPLY->name, $step * $limit, $limit);

            $th = ['스팀 닉네임', '네이버 아이디', '디스코드 사용자명', '생년월일', '타 클랜 활동', '신청일', '상세 정보'];
            $tr = array();

            foreach ($users as $user)
            {
                $steamAccount = $accountRepository->findSteamAccountByUserId($user->id);
                $application = $surveyService->getLatestApplicationForm($user->id);
                $response = $application->answers()->latest()->get();

                $row = [
                    $user->id,
                    "<a class='link-indigo' href='https://steamcommunity.com/profiles/{$steamAccount->account_id}' target='_blank'>{$steamAccount->nickname}</a>",
                    '', '', '', '',
                    $application->created_at->toDateString(),
                    '<a class="link-indigo" href="'. route('admin.application.read', $user->id) .'">확인하기</a>'
                ];

                foreach ($response as $item)
                {
                    $question = $item->question()->first();
                    $value = $item->value;

                    if (is_null($question)) continue;

                    switch ($question->title) {
                        case '네이버 아이디':
                            $value = explode ('@', $value)[0];
                            $row[2] = "<a class='link-indigo' href='https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId={$value}' target='_blank'>{$value}</a>";
                            break;

                        case '디스코드 사용자명': $row[3] = $value; break;

                        case '본인의 생년월일': $row[4] = $value; break;

                        case '아르마 커뮤니티(클랜) 활동 여부': $row[5] = $value; break;
                    }
                }

                $tr[] = $row;
            }

            return $this->jsonResponse(200, 'OK', [
                'checkbox' => true,
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
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function process(Request $request, UserServiceContract $userService)
    {
        try
        {
            $this->jsonValidator($request, [
                'type' => ['required', 'string'],
                'user_id' => ['required', 'array'], // 없애면 안된다! 가입 신청자 리스트에서 처리를 해야하기 때문
                'reason' => ''
            ]);

            if (count($request->get('user_id')) <= 0) {
                throw new \Exception('USER NOT SELECTED', 422);
            }

            $type = $request->get('type');
            $reason = strip_tags($request->get('reason'));
            $executor = Auth::user();

            $roles = [RoleType::DEFER->name, RoleType::REJECT->name, RoleType::MEMBER->name];

            if (!in_array($type, $roles))
            {
                throw new \Exception('INVALID TYPE', 422);
            }

            $users = $this->userRepository->findByIdsWithRole($request->get('user_id'), RoleType::APPLY->name);

            foreach ($users as $user)
            {
                $user->removeRole(RoleType::APPLY->name);
                $user->assignRole($type);

                $data = [
                    'role' => $type,
                    'reason' => $reason
                ];

                $userService->createRecord($user->id, UserRecordType::ROLE_DATA->name, $data, $executor->id);

                if ($type === RoleType::REJECT->name)
                {
                    $count = $userService->findRoleRecordeByUserId($user->id, $user::ROLE_REJECT)->count();
                    $ban = array();

                    if ($count == 1)
                    {
                        $ban = [
                            'comment' => "가입이 거절되어 계정이 일시 정지되었습니다. 30일 이후 가입 신청을 하실 수 있습니다.<br/><br/><span class='font-bold'>가입 거절 사유:</span><br/>{$reason}",
                            'expired_at' => now()->addDays(30),
                        ];
                    }

                    if ($count >= 2)
                    {
                        $ban = [
                            'comment' => "가입이 2번 거절되어 계정이 무기한 정지되었습니다. 더 이상 가입 신청을 하실 수 없습니다.<br/><br/><span class='font-bold'>가입 거절 사유:</span><br/>{$reason}"
                        ];
                    }

                    $user->ban($ban);
                }
            }

            return $this->jsonResponse(200, 'OK', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
