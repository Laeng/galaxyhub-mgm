<?php

namespace App\Http\Controllers\Admin\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): View
    {
        return view('admin.Application.index');
    }

    public function data(Request $request, SurveyRepositoryInterface $surveyRepository, UserAccountRepositoryInterface $accountRepository): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $step = $request->get('step', 0);
            $limit = $request->get('limit', 20);

            if ($limit < 1 || $limit > 100) $limit = 20;

            $applicationFormIds = $surveyRepository->findApplicationForms(['id'])->pluck('id')->values();

            $count = $this->userRepository->findByRole(\App\Models\User::ROLE_APPLY)->count();
            $users = $this->userRepository->findByRoleWithPagination(\App\Models\User::ROLE_APPLY, $step * $limit, $limit);

            $th = ['스팀 닉네임', '네이버 아이디', '생년월일', '타 클랜 활동', '신청일', '상세 정보'];
            $tr = array();

            foreach ($users as $user)
            {
                $steamAccount = $accountRepository->findByUserId($user->id)?->filter(fn ($v, $k) => $v->provider === 'steam')?->first();

                $application = $user->surveys()->whereIn('id', $applicationFormIds)->latest()->first();
                $response = $application->answers()->latest()->get();

                $row = [
                    $user->id,
                    "<a class='link-indigo' href='https://steamcommunity.com/profiles/{$steamAccount->account_id}' target='_blank'>{$steamAccount->nickname}</a>",
                    '', '', '',
                    $application->created_at->toDateString(),
                    '<a class="link-indigo" href="'. route('admin.application.read', $user->id) .'">확인하기</a>'
                ];

                foreach ($response as $item)
                {
                    $question = $item->question()->first();
                    $v = $item->value;

                    if (is_null($question)) continue;

                    switch ($question->title) {
                        case '네이버 아이디':
                            $row[2] = "<a class='link-indigo' href='https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId={$v}' target='_blank'>{$v}</a>";
                            break;

                        case '본인의 생년월일': $row[3] = $v; break;

                        case '아르마 커뮤니티(클랜) 활동 여부': $row[4] = $v; break;
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
}
