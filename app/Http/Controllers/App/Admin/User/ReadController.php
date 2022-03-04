<?php

namespace App\Http\Controllers\App\Admin\User;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function read
    (
        Request $request, int $userId, UserAccountRepositoryInterface $userAccountRepository,
        UserMissionRepositoryInterface $userMissionRepository, SurveyServiceContract $surveyService
    ): View
    {
        $user = $this->userRepository->findById($userId);
        $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id, ['account_id'])->first();
        $userMission = $userMissionRepository->findAttendedMissionByUserId($user->id);

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


        return view('app.admin.user.read', [
            'title' => $user->name,
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

}
