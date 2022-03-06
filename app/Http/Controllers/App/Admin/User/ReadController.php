<?php

namespace App\Http\Controllers\App\Admin\User;

use App\Enums\BadgeType;
use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\Badge\Interfaces\BadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserBadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    private BadgeRepositoryInterface $badgeRepository;
    private UserRepositoryInterface $userRepository;
    private UserBadgeRepositoryInterface $userBadgeRepository;
    private UserMissionRepositoryInterface $userMissionRepository;

    public function __construct
    (
        UserRepositoryInterface $userRepository, UserBadgeRepositoryInterface $userBadgeRepository,
        BadgeRepositoryInterface $badgeRepository, UserMissionRepositoryInterface $userMissionRepository,
    )
    {
        $this->badgeRepository = $badgeRepository;
        $this->userRepository = $userRepository;
        $this->userBadgeRepository = $userBadgeRepository;
        $this->userMissionRepository = $userMissionRepository;
    }

    public function read
    (
        Request $request, int $userId, UserAccountRepositoryInterface $userAccountRepository,
        SurveyServiceContract $surveyService,
    ): View
    {
        $user = $this->userRepository->findById($userId);
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

        $userBadges = $this->userBadgeRepository->findByUserId($userId, ['*'], ['badge']);
        $userBadge = array();

        foreach ($userBadges as $badge)
        {
            $userBadge[] = [
                'name' => BadgeType::getKoreanNames()[$badge->badge->name],
                'icon' => asset($badge->badge->icon)
            ];
        }

        $badges = $this->badgeRepository->all();
        $badge = array();

        foreach ($badges as $item)
        {
            $badge[] = [
                'id' => $item->id,
                'name' => BadgeType::getKoreanNames()[$item->name],
                'icon' => asset($item->icon),
                'checked' => $userBadges->first(fn ($v, $k) => $v->badge->id === $item->id)
            ];
        }

        return view('app.admin.user.read', [
            'title' => $user->name,
            'user' => $user,
            'steamAccount' => $steamAccount,
            'userMission' => $userMission,
            'badge' => json_encode($badge),
            'userBadge' => json_encode($userBadge),
            'group' => RoleType::getKoreanNames()[$role->name],
            'groups' => json_encode(array_flip(RoleType::getKoreanNames())),
            'missionCount' => $missionCount,
            'missionLatest' => $missionLatest,
            'naverId' => $naverId,
            'discordName' => $discordName,
            'birthday' => $birthday
        ]);

    }

    public function data(Request $request, int $userId): JsonResponse
    {
        try
        {
            $user = $this->userRepository->findById($userId);
            $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);
            $role = $user->roles()->latest()->first();

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

            $userBadges = $this->userBadgeRepository->findByUserId($userId, ['*'], ['badge']);
            $userBadge = array();

            foreach ($userBadges as $badge)
            {
                $userBadge[] = [
                    'name' => BadgeType::getKoreanNames()[$badge->badge->name],
                    'icon' => asset($badge->badge->icon)
                ];
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'badges' => $userBadge,
                'group' => RoleType::getKoreanNames()[$role->name],
                'mission_count' => $missionCount,
                'mission_date' => $missionLatest,
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function badge(Request $request, int $userId): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'badges' => 'array'
            ]);

            $user = $this->userRepository->findById($userId);
            $badgesIds = $this->badgeRepository->all(['id'])->pluck('id')->toArray();
            $userBadges = $this->userBadgeRepository->findByUserId($user->id, ['id', 'badge_id'], ['badge']);

            foreach ($userBadges as $item)
            {
                $this->userBadgeRepository->delete($item->id);
            }

            $inputBadges = $request->get('badges');

            foreach ($inputBadges as $item)
            {
                if (in_array($item, $badgesIds))
                {
                    $this->userBadgeRepository->create([
                        'user_id' => $user->id,
                        'badge_id' => $item,
                    ]);
                }
            }

            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

}
