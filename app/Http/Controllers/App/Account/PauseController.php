<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\BanCommentType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Ban\Interfaces\BanRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
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
    private BanRepositoryInterface $banRepository;

    public function __construct
    (
        UserMissionRepository $userMissionRepository, UserRecordRepositoryInterface $userRecordRepository,
        UserServiceContract $userService, BanRepositoryInterface $banRepository
    )
    {
        $this->userMissionRepository = $userMissionRepository;
        $this->userRecordRepository = $userRecordRepository;
        $this->userService = $userService;
        $this->banRepository = $banRepository;
    }

    public function pause(Request $request): View
    {
        $user = Auth::user();
        $userMission = $this->userMissionRepository->findAttendedMissionByUserId($user->id);

        $ban = $this->banRepository->findByUserId($user->id)->first();

        $pause = $this->userRecordRepository->findByUserIdAndTypes($user->id, [UserRecordType::USER_PAUSE_ENABLE->name, UserRecordType::USER_PAUSE_DISABLE->name])->first();
        $isPause = !is_null($pause) && $pause->type === UserRecordType::USER_PAUSE_ENABLE->name;

        if (!is_null($ban) && (is_null($ban->expired_at) || !$ban->expired_at->isPast()))
        {
            $canPause = $ban->comment === BanCommentType::USER_PAUSE->value;
        }
        else
        {
            $canPause = !is_null($userMission) && $userMission->count() > 0;
        }

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
            $ban = $this->banRepository->findByUserId($user->id)->first();

            if (!is_null($ban) && (is_null($ban->expired_at) || !$ban->expired_at->isPast()))
            {
                if ($ban->comment !== BanCommentType::USER_PAUSE->value)
                {
                    throw new \Exception('BANNED USER', 422);
                }
            }

            if (!$this->isEnabled($user->id))
            {
                $this->userService->createRecord($user->id, UserRecordType::USER_PAUSE_ENABLE->name, [
                    'comment' => '회원님이 장기 미접속을 신청하였습니다.'
                ]);
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
            $ban = $this->banRepository->findByUserId($user->id)->first();

            if (!is_null($ban) && (is_null($ban->expired_at) || !$ban->expired_at->isPast()))
            {
                if ($ban->comment !== BanCommentType::USER_PAUSE->value)
                {
                    throw new \Exception('BANNED USER', 422);
                }
            }

            if ($this->isEnabled($user->id))
            {
                $ban = $user->bans()->where('comment', BanCommentType::USER_PAUSE->value)->latest()->first();
                
                if (is_null($ban) || $ban->comment === BanCommentType::USER_PAUSE->value)
                {
                    $data = [
                        'comment' => '회원님이 장기 미접속을 해제 하였습니다.'
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

    private function isEnabled(int $userId): bool
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
