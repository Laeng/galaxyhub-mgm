<?php

namespace App\Http\Controllers\App\Admin\Application;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Repositories\User\UserAccountRepository;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    private UserServiceContract $userService;
    private UserRepositoryInterface $userRepository;
    private UserRecordRepositoryInterface $recordRepository;
    private SurveyServiceContract $surveyService;

    public function __construct
    (
        UserServiceContract $userService, UserRepositoryInterface $userRepository,
        UserRecordRepositoryInterface $recordRepository, SurveyServiceContract $surveyService
    )
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->recordRepository = $recordRepository;
        $this->surveyService = $surveyService;
    }

    public function read(Request $request, int $userId, UserAccountRepositoryInterface $userAccountRepository): View
    {
        $user = $this->userRepository->findById($userId);

        if (is_null($user))
        {
            abort('404');
        }

        $isBanned = false;
        $isRejoin = false;

        $application = $this->surveyService->getLatestApplicationForm($user->id);
        $survey = !is_null($application) ? $application?->survey()->first() : null;

        $quiz = $this->surveyService->getLatestApplicationQuiz($user->id);
        $survey_quiz = !is_null($quiz) ? $quiz->survey()->first() : null;

        if ($user->hasPermissionTo(PermissionType::MEMBER->name))
        {
            $role = RoleType::MEMBER;
            $status = '승인';
        }
        else
        {
            $role = null;
            $status = null;

            $hasRole = false;

            if ($user->hasRole(RoleType::APPLY->name))
            {
                $role = RoleType::APPLY;
                $status = '접수';
                $hasRole = true;
            }
            if ($hasRole == false && $user->hasRole(RoleType::DEFER->name))
            {
                $role = RoleType::DEFER;
                $status = '보류';
                $hasRole = true;
            }
            if ($hasRole == false && $user->hasRole(RoleType::REJECT->name))
            {
                $role = RoleType::DEFER;
                $status = '거절';
            }

            $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id)->first();

            if (!is_null($steamAccount))
            {
                $records = $this->recordRepository->findByUuid($this->recordRepository->getUuidV5($steamAccount->account_id));

                foreach ($records as $record)
                {
                    if ($record->type === UserRecordType::BAN_DATA->name && !array_key_exists('expired_at', $record->data))
                    {
                        $isBanned = true;
                    }

                    if ($record->type === UserRecordType::USER_DELETE->name)
                    {
                        $isRejoin = true;
                    }
                }
            }
        }

        $record = !is_null($role) ? $this->userService->findRoleRecordeByUserId($user->id, $role->name)->first() : null;
        $admin = !is_null($record?->recorder_id) ? $this->userRepository->findById($record->recorder_id) : null;

        return view('app.admin.application.read', [
            'user' => $user,
            'admin' => $admin,
            'application' => $application,
            'record' => $record,
            'role' => $role,
            'title' => "{$user->name}님의 신청서",
            'survey' => $survey,
            'answer' => !is_null($quiz) ? $application->id : null,
            'quiz' => $survey_quiz,
            'quiz_answer' => !is_null($quiz) ? $quiz->id : null,
            'status' => $status ?? '약관 동의',
            'isBanned' => $isBanned,
            'isRejoin' => $isRejoin,
        ]);
    }

    public function games(Request $request, int $userId): View
    {
        $user = $this->userRepository->findById($userId);

        if (is_null($user))
        {
            abort('404');
        }

        $games = $this->recordRepository->findByUserIdAndType($user->id, UserRecordType::STEAM_DATA_GAMES->name)->first();

        return view('app.admin.application.read-games', [
            'user' => $user,
            'games' => json_encode($games->data),
            'title' => "{$user->name}님의 게임",
            'date' => $games->created_at->format('Y-m-d')
        ]);
    }

    public function data(Request $request, int $userId, SteamServiceContract $steamService): JsonResponse
    {
        try
        {
            if (is_null($userId))
            {
                throw new \Exception('NOT FOND USER', 422);
            }

            $user = $this->userRepository->findById($userId);

            if (is_null($user))
            {
                throw new \Exception('NOT FOUND USER', 422);
            }

            $application = $this->surveyService->getLatestApplicationForm($user->id);
            $response = $application?->answers()->get();

            if (is_null($application))
            {
                throw new \Exception('NOT FOUND APPLICATION', 422);
            }

            $summaries = $this->recordRepository->findByUserIdAndType($userId, UserRecordType::STEAM_DATA_SUMMARIES->name)->first();

            if (is_null($summaries) || count($summaries->data) <= 0)
            {
                $summaries = new \stdClass();
                $summaries->data = [
                    'steamid' => ''
                ];
            }

            $group = $this->recordRepository->findByUserIdAndType($userId, UserRecordType::STEAM_DATA_GROUPS->name)->first();

            if (is_null($group) || count($group->data) <= 0)
            {
                $group = new \stdClass();
                $group->data = [
                    'groupID64' => '',
                    'groupDetails' => [
                        'groupName' => '',
                        'avatarFull' => '',
                        'summary' => ''
                    ]
                ];
            }

            $arma3 = $this->recordRepository->findByUserIdAndType($userId, UserRecordType::STEAM_DATA_ARMA3->name)->first();

            if (is_null($arma3) || count($arma3->data) <= 0)
            {
                $arma3 = new \stdClass();
                $arma3->data = [
                    'playtime_forever' => ''
                ];
            }

            $ban = $this->recordRepository->findByUserIdAndType($userId, UserRecordType::STEAM_DATA_BANS->name)->first();

            if (is_null($ban) || count($ban->data) <= 0)
            {
                $ban = new \stdClass();
                $ban->data = [
                    'NumberOfVACBans' => 'NaN',
                    'NumberOfGameBans' => 'NaN'
                ];
            }


            $naverId = null;

            foreach ($response as $item)
            {
                $question = $item->question()->first();
                $value = $item->value;

                if (is_null($question)) continue;

                if ($question->title == '네이버 아이디') {
                    $naverId = explode('@', $value)[0];
                }
            }

            return $this->jsonResponse(200, 'OK', [
                'summaries' => $summaries?->data,
                'group' => $group?->data,
                'arma' => $arma3?->data,
                'ban' => $ban?->data,
                'naver_id' => $naverId,
                'created_at' => isset($summaries->updated_at) ? "{$summaries->updated_at->format('Y-m-d')} 기준" : '',
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function steam(Request $request, ?int $userId)
    {
        try
        {
            if (is_null($userId))
            {
                throw new \Exception('NOT FOND USER', 422);
            }

            $user = $this->userRepository->findById($userId);

            if (is_null($user))
            {
                throw new \Exception('NOT FOUND USER', 422);
            }

            $result = $this->userService->updateSteamAccount($user->id);

            return $this->jsonResponse(200, 'OK', [
                'result' => $result
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
