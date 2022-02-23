<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\UserMissionRepository;
use App\Services\Survey\Contracts\SurveyServiceContract;
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

    public function me
    (
        Request $request, UserAccountRepositoryInterface $userAccountRepository, SurveyServiceContract $surveyServiceContract
    ): View
    {
        $user = Auth::user();
        $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id, ['account_id']);
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);

        if (!is_null($userMission))
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

        $application = $surveyServiceContract->getLatestApplicationForm($user->id);
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
            'user' => Auth::user(),
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

    public function pause(Request $request, UserRecordRepositoryInterface $userRecordRepository): View
    {
        $user = Auth::user();
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);

        $enable = $userRecordRepository->findByUserIdAndType($user->id, UserRecordType::USER_PAUSE_ENABLE->name)->first();
        $disable = $userRecordRepository->findByUserIdAndType($user->id, UserRecordType::USER_PAUSE_DISABLE->name)->first();

        $isPause = true;

        if (!is_null($enable) && !is_null($disable))
        {
            if ($enable->craeted_at->isPast() && $disable->created_at->isPast())
            {
                $isPause = false;
            }
        }

        if (is_null($enable) && is_null($disable))
        {
            $isPause = False;
        }

        $canPause = $userMission->count() > 0;

        return view('app.account.pause', [
            'title' => '장기 미접속 신청',
            'user' => Auth::user(),
            'canPause' => $canPause,
            'isPause' => $isPause
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
