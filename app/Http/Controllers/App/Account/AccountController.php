<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\UserMissionRepository;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    private UserMissionRepository $userMissionRepository;

    public function __construct(UserMissionRepository $userMissionRepository)
    {
        $this->userMissionRepository = $userMissionRepository;
    }

    public function delete(Request $request, UserServiceContract $userService): JsonResponse
    {
        try
        {
            $user = Auth::user();

            $userService->delete($user->id);
            $userService->createRecord($user->id, UserRecordType::USER_DELETE->name, [
                'comment' => "{$user->name}님의 요청으로 계정 데이터를 삭제하였습니다."
            ]);

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function leave(Request $request): View
    {
        return view('app.account.leave', [
            'title' => '데이터 삭제',
            'user' => Auth::user(),
        ]);
    }

    public function me
    (
        Request $request, UserAccountRepositoryInterface $userAccountRepository, SurveyServiceContract $surveyService
    ): View
    {
        $user = Auth::user();
        $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id, ['account_id'])->first();
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);

        if (!is_null($userMission) && $userMission->count() > 0)
        {
            $missionCount = $userMission->count();
            $missionLatest = $userMission->first()->attended_at->format('Y-m-d');
        }
        else
        {
            $missionCount = 0;
            $missionLatest = '참가하지 않음';
        }

        $role = $user->roles()->latest()->first();

        $application = $surveyService->getLatestApplicationForm($user->id);
        $response = $application->answers()->latest()->get();

        $naverId = '';
        $discordName = '';
        $birthday = '';

        foreach ($response as $item)
        {
            $question = $item->question()->first();
            $value = $item->value;

            if (is_null($question)) continue;

            switch ($question->title) {
                case '네이버 아이디': $naverId = explode ('@', $value)[0]; break;

                case '디스코드 사용자명': $discordName = $value; break;

                case '본인의 생년월일': $birthday = $value; break;
            }
        }


        return view('app.account.me', [
            'title' => '개인 정보',
            'user' => $user,
            'steamAccount' => $steamAccount,
            'userMission' => $userMission,
            'role' => RoleType::getKoreanNames()[$role->name],
            'missionCount' => $missionCount,
            'missionLatest' => $missionLatest,
            'naverId' => $naverId,
            'discordName' => $discordName,
            'birthday' => $birthday
        ]);
    }

    public function suspended(Request $request): View
    {
        $user = Auth::user();
        $ban = $user->bans()->latest()->first();

        if (is_null($ban))
        {
            abort(404);
        }

        $ban->comment = match ($ban->comment) {
            '장기미접속' => '회원님의 장기 미접속 신청이 접수되어 계정이 정지되었습니다.<br/> 만약 활동을 재개하시기로 결정하셨다면, <a href="https://cafe.naver.com/ArticleList.nhn?search.clubid=17091584&search.menuid=223&search.boardtype=L" class="link-indigo" target="_blank">커뮤니티</a>에서 권한 복구 신청해주시기 바랍니다.',
            default => $ban->comment
        };

        return view('app.account.suspended', [
            'comment' => $ban->comment,
            'isPermanent' => is_null($ban->expired_at),
            'ban' => $ban
        ]);
    }
}
