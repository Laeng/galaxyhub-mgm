<?php

namespace App\Http\Controllers\App\Memo;

use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    private UserServiceContract $userService;
    private UserRepositoryInterface $userRepository;
    private UserRecordRepositoryInterface $recordRepository;

    public function __construct(UserServiceContract $userService, UserRepositoryInterface $userRepository, UserRecordRepositoryInterface $recordRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->recordRepository = $recordRepository;
    }

    public function list(Request $request): JsonResponse
    {
        /* 등급 변경시 변경 기록 남길 때, reason 대신 comment 를 사용하도록 달고, 추후 MEMO 불러올 때는 comment 로 단일화 해서 내용이 출력되도록 하자! */

        try
        {
            $this->jsonValidator($request, [
                'user_id' => ['int', 'required']
            ]);

            $target = $this->userRepository->findById($request->get('user_id'));

            if (is_null($target))
            {
                throw new \Exception('NOT FOUND USER', 422);
            }

            $records = $this->recordRepository->findByUserId($target->id);
            $data = array();

            foreach ($records as $record)
            {
                if (empty($record->data['comment'])) continue;

                $userRecordType = array_flip(UserRecordType::getKoreanNames());
                $type = array_flip(UserRecordType::getKoreanNames())[$record->type];

                $datum = [
                    'recorder' => [
                        'avatar' => null,
                        'name' => null
                    ],
                    'id' => $record->id,
                    'type' => $type,
                    'comment' => nl2br($record->data['comment']),
                    'date' => $record->created_at->format('Y-m-d H:i'),
                    'can_delete' => false
                ];

                if (!is_null($record->recorder_id))
                {
                    $recorder = $this->userRepository->findById($record->recorder_id);

                    if (!is_null($recorder))
                    {
                        $datum['recorder']['avatar'] = $recorder->avatar;
                        $datum['recorder']['name'] = $recorder->name;

                        $user = Auth::user();

                        if ($recorder->id === $user->id && $record->type === UserRecordType::USER_MEMO_FOR_ADMIN->name)
                        {
                            $datum['can_delete'] = true;
                        }
                    }
                    else
                    {
                        $datum['recorder']['avatar'] = asset('images/avatar.png');
                        $datum['recorder']['name'] = '탈퇴 회원';
                    }
                }
                else
                {
                    $datum['recorder']['avatar'] = asset('images/avatar.png');
                    $datum['recorder']['name'] = 'SYSTEM';
                }

                $data[] = $datum;
            }

            return $this->jsonResponse(200, 'SUCCESS', ['records' => $data]);

        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'user_id' => ['int', 'required'],
                'comment' => ['string', 'required']
            ]);

            $user = Auth::user();

            $data = [
                'comment' => strip_tags($request->get('comment'))
            ];

            $target = $this->userRepository->findById($request->get('user_id'));

            if (is_null($target))
            {
                throw new \Exception('NOT FOUND USER', 422);
            }

            $this->userService->createRecord($target->id, UserRecordType::USER_MEMO_FOR_ADMIN->name, $data, $user->id);

            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'user_id' => ['int', 'required'],
                'memo_id' => ['int', 'required']
            ]);

            $recode = $this->recordRepository->findById($request->get('memo_id'));

            if (is_null($recode))
            {
                throw new \Exception('NOT FOUND MEMO', 422);
            }

            $user = Auth::user();

            if ($recode->recorder_id !== $user->id)
            {
                throw new \Exception('NOT RECORDER', 422);
            }

            $recode->delete();

            return $this->jsonResponse('200', 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
