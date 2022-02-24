<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\BanCommentType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\UserMissionRepository;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PauseController extends Controller
{
    private UserMissionRepository $userMissionRepository;
    private UserRecordRepositoryInterface $userRecordRepository;
    private UserServiceContract $userService;

    public function __construct
    (
        UserMissionRepository $userMissionRepository, UserRecordRepositoryInterface $userRecordRepository,
        UserServiceContract $userService
    )
    {
        $this->userMissionRepository = $userMissionRepository;
        $this->userRecordRepository = $userRecordRepository;
        $this->userService = $userService;
    }

    public function pause(Request $request): View
    {
        $user = Auth::user();
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);
        $pause = $this->userRecordRepository->findByUserIdAndTypes($user->id, [UserRecordType::USER_PAUSE_ENABLE->name, UserRecordType::USER_PAUSE_DISABLE->name])->first();

        $canPause = !is_null($userMission) && $userMission->count() > 0;
        $isPause = !is_null($pause) && $pause->type === UserRecordType::USER_PAUSE_ENABLE->name;

        return view('app.account.pause', [
            'title' => '장기 미접속',
            'user' => Auth::user(),
            'canPause' => $canPause,
            'isPause' => $isPause
        ]);
    }

    public function enable(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $user = Auth::user();

            if (!$this->can($user->id))
            {
                $this->userService->createRecord($user->id, UserRecordType::USER_PAUSE_ENABLE->name, ['comment' => ' ']);
                $user->ban(['comment' => BanCommentType::USER_PAUSE->value]);
            }

            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function disable(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $user = Auth::user();

            if ($this->can($user->id))
            {
                $ban = $user->bans()->first();

                if (is_null($ban) || $ban->comment === BanCommentType::USER_PAUSE->value)
                {
                    $data = [
                        'comment' => ' '
                    ];

                    $this->userService->createRecord($user->id, UserRecordType::USER_PAUSE_DISABLE->name, $data);
                    $user->unban();
                }
                else
                {
                    throw new \Exception('CONTACT TO MANAGER', 422);
                }
            }

            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    private function can(int $userId): bool
    {
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($userId);
        $pause = $this->userRecordRepository->findByUserIdAndTypes($userId, [UserRecordType::USER_PAUSE_ENABLE->name, UserRecordType::USER_PAUSE_DISABLE->name])->first();

        if (is_null($userMission) || $userMission->count() <= 0)
        {
            return false;
        }

        return !is_null($pause) && $pause->type === UserRecordType::USER_PAUSE_ENABLE->name;
    }
}
