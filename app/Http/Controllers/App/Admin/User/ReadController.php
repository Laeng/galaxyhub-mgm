<?php

namespace App\Http\Controllers\App\Admin\User;

use App\Enums\BadgeType;
use App\Enums\MissionPhaseType;
use App\Enums\MissionType;
use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Badge\Interfaces\BadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserBadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadController extends Controller
{
    private BadgeRepositoryInterface $badgeRepository;
    private UserRepositoryInterface $userRepository;
    private UserBadgeRepositoryInterface $userBadgeRepository;
    private UserMissionRepositoryInterface $userMissionRepository;
    private UserServiceContract $userService;

    public function __construct
    (
        UserRepositoryInterface $userRepository, UserBadgeRepositoryInterface $userBadgeRepository,
        BadgeRepositoryInterface $badgeRepository, UserMissionRepositoryInterface $userMissionRepository,
        UserServiceContract $userService
    )
    {
        $this->badgeRepository = $badgeRepository;
        $this->userRepository = $userRepository;
        $this->userBadgeRepository = $userBadgeRepository;
        $this->userMissionRepository = $userMissionRepository;
        $this->userService = $userService;
    }

    public function read
    (
        Request $request, int $userId, UserAccountRepositoryInterface $userAccountRepository,
        SurveyServiceContract $surveyService
    ): View|RedirectResponse
    {
        $user = $this->userRepository->findById($userId);

        if ($user == null)
        {
            abort(404);
        }

        $application = $surveyService->getLatestApplicationForm($user->id);

        if (is_null($application))
        {
            return redirect()->route('admin.application.read', $user->id);
        }

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

        $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id, ['account_id'])->first();
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);

        if (!is_null($userMission) && $userMission->count() > 0)
        {
            $missionCount = $userMission->count();
            $missionLatest = $userMission->first()->attended_at->format('Y-m-d');

            $missionMakeCount = $this->userMissionRepository->new()->where('user_id', $user->id)->where('is_maker', true)->count();
        }
        else
        {
            $missionCount = 0;
            $missionMakeCount = 0;
            $missionLatest = '참가하지 않음';
        }

        $role = $user->roles()->latest()->first();

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

        $ban = '';
        if ($user->isBanned())
        {
            $userBan = $user->bans()->first();
            $ban = is_null($userBan->expired_at) ? '무기한' : "{$userBan->expired_at->format('Y년 m월 d일 H시 i분')} 까지";
        }

        $steamPlayer = $this->userService->getRecord($user->id, UserRecordType::STEAM_DATA_SUMMARIES->name);
        $steamDataDate = '등록 안됨';
        if ($steamPlayer->count() > 0)
        {
            $steamDataDate = $steamPlayer->first()->updated_at->format('Y-m-d H:i:s');
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
            'missionMakeCount' => $missionMakeCount,
            'missionLatest' => $missionLatest,
            'naverId' => $naverId,
            'discordName' => $discordName,
            'birthday' => $birthday,
            'types' => MissionType::getKoreanNames(),
            'ban' => $ban,
            'steamDataDate' => $steamDataDate
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

                $missionMakeCount = $this->userMissionRepository->new()->where('user_id', $user->id)->where('is_maker', true)->count();
            }
            else
            {
                $missionCount = 0;
                $missionMakeCount = 0;
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

            $ban = '';
            if ($user->isBanned())
            {
                $userBan = $user->bans()->first();
                $ban = is_null($userBan->expired_at) ? '무기한' : "{$userBan->expired_at->format('Y년 m월 d일 H시 i분')} 까지";
            }

            $steamPlayer = $this->userService->getRecord($user->id, UserRecordType::STEAM_DATA_SUMMARIES->name);
            $steamDataDate = '등록 안됨';
            if ($steamPlayer->count() > 0)
            {
                $steamDataDate = $steamPlayer->first()->updated_at->format('Y-m-d H:i:s');
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'badges' => $userBadge,
                'group' => RoleType::getKoreanNames()[$role->name],
                'mission_count' => $missionCount,
                'mission_make_count' => $missionMakeCount,
                'mission_date' => $missionLatest,
                'ban' => $ban,
                'steam_date' => $steamDataDate
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

    public function participate(Request $request, int $userId): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $user = $this->userRepository->findById($userId);
            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            $query = $this->userMissionRepository->new()->where('user_id', $user->id);
            $conditions = array();

            if (isset($q['type'])) {
                $conditions[] = ['type', '=', $q['type']];
            }

            foreach ($conditions as $condition)
            {
                $query = $query->whereHas('mission', function ($query) use ($condition) {
                    $query->where($condition[0], $condition[1], $condition[2]);
                });
            }

            $count = $query->count();

            $th = ['분류', '시작 시간', '미션 메이커', '&nbsp;', '미션'];
            $tr = array();

            if ($count > 0)
            {
                $step = $this->getPaginationStep($step, $limit, $count);
                $userMission = $query->latest()->offset($step * $limit)->limit($limit)->get();

                $missionType = MissionType::getKoreanNames();

                foreach ($userMission as $item)
                {
                    $mission = $item->mission;
                    $url = route('mission.read', $mission->id);
                    $text = ['link-indigo', '미션 정보'];

                    if ($mission->user_id !== $user->id)
                    {
                        $hasFailAttendance = $item->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
                        $hasAttend = !is_null($item->attended_at);
                        $canAttend = !$hasFailAttendance && $mission->phase === MissionPhaseType::IN_ATTENDANCE->value;

                        if ($mission->phase >= MissionPhaseType::IN_ATTENDANCE->value)
                        {
                            if (!$hasAttend)
                            {
                                if ($canAttend)
                                {
                                    $text = ['link-yellow', '출석 하기'];
                                }
                                else
                                {
                                    $text = ['link-red', '출석 실패'];
                                }
                            }
                            else
                            {
                                $text = ['link-green', '출석 성공'];
                            }
                        }
                    }

                    $row = [
                        $missionType[$mission->type],
                        $mission->expected_at->format('m월 d일 H시 i분'),
                        $mission->user()->first()->name,
                        "<a href='{$url}' class='{$text[0]}' title='{$text[1]}'>{$text[1]}</a>",
                        "<a href='{$url}' title='{$mission->title}'><div class='flex justify-between'><p>{$mission->title}</p><p class='{$text[0]}'>{$text[1]}</p></div>"
                    ];

                    $tr[] = $row;
                }

            }
            else
            {
                $th = ['신청한 미션이 없습니다.', '신청한 미션이 없습니다.'];
            }


            return $this->jsonResponse(200, 'SUCCESS', [
                'checkbox' => false,
                'mobile' => true,
                'name' => '',
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

    public function make(Request $request, int $userId): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $user = $this->userRepository->findById($userId);
            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            $query = $this->userMissionRepository->new()->where('user_id', $user->id)->where('is_maker', true);
            $conditions = array();

            if (isset($q['type'])) {
                $conditions[] = ['type', '=', $q['type']];
            }

            foreach ($conditions as $condition)
            {
                $query = $query->whereHas('mission', function ($query) use ($condition) {
                    $query->where($condition[0], $condition[1], $condition[2]);
                });
            }

            $count = $query->count();

            $th = ['분류', '시작 시간', '미션 메이커', '&nbsp;', '미션'];
            $tr = array();

            if ($count > 0)
            {
                $step = $this->getPaginationStep($step, $limit, $count);
                $userMission = $query->latest()->offset($step * $limit)->limit($limit)->get();

                $missionType = MissionType::getKoreanNames();

                foreach ($userMission as $item)
                {
                    $mission = $item->mission;
                    $url = route('mission.read', $mission->id);
                    $text = ['link-indigo', '미션 정보'];

                    if ($mission->user_id !== $user->id)
                    {
                        $hasFailAttendance = $userMission->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
                        $hasAttend = !is_null($userMission->attended_at);
                        $canAttend = !$hasFailAttendance && $mission->phase === MissionPhaseType::IN_ATTENDANCE->value;

                        if ($mission->phase >= MissionPhaseType::IN_ATTENDANCE->value)
                        {
                            if (!$hasAttend)
                            {
                                if ($canAttend)
                                {
                                    $text = ['link-yellow', '출석 하기'];
                                }
                                else
                                {
                                    $text = ['link-red', '출석 실패'];
                                }
                            }
                            else
                            {
                                $text = ['link-green', '출석 성공'];
                            }
                        }
                    }

                    $row = [
                        $missionType[$mission->type],
                        $mission->expected_at->format('m월 d일 H시 i분'),
                        $mission->user()->first()->name,
                        "<a href='{$url}' class='{$text[0]}' title='{$text[1]}'>{$text[1]}</a>",
                        "<a href='{$url}' title='{$mission->title}'><div class='flex justify-between'><p>{$mission->title}</p><p class='{$text[0]}'>{$text[1]}</p></div>"
                    ];

                    $tr[] = $row;
                }

            }
            else
            {
                $th = ['만든 미션이 없습니다.', '만든 미션이 없습니다.'];
            }


            return $this->jsonResponse(200, 'SUCCESS', [
                'checkbox' => false,
                'mobile' => true,
                'name' => '',
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
