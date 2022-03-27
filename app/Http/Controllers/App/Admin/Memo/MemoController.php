<?php

namespace App\Http\Controllers\App\Admin\Memo;

use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\File\Contracts\FileServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use function asset;
use function config;

class MemoController extends Controller
{
    private FileServiceContract $fileService;
    private UserServiceContract $userService;
    private UserRepositoryInterface $userRepository;
    private UserRecordRepositoryInterface $recordRepository;

    public function __construct
    (
        UserServiceContract $userService, UserRepositoryInterface $userRepository,
        UserRecordRepositoryInterface $recordRepository, FileServiceContract $fileService
    )
    {
        $this->fileService = $fileService;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->recordRepository = $recordRepository;
    }

    public function list(Request $request, UserAccountRepositoryInterface $userAccountRepository): JsonResponse
    {
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

            $steamAccount = $userAccountRepository->findSteamAccountByUserId($target->id)->first();
            $records = $this->recordRepository->findByUuid($this->recordRepository->getUuidV5($steamAccount->account_id));
            $data = array();

            foreach ($records as $record)
            {
                if (!array_key_exists('comment', $record->data)) continue;

                $type = array_flip(UserRecordType::getKoreanNames())[$record->type];

                if ($record->type === UserRecordType::USER_MEMO_IMAGE_FORM_ADMIN->name)
                {
                    $html = '';
                    $imageIds = json_decode($record->data['comment']);

                    foreach ($imageIds as $imageId)
                    {
                        $path = $this->fileService->getUrl($imageId);
                        $html .= "<a class='flex justify-center items-center' href='{$path}' target='_blank' rel='noopener'><img class='object-scale-down rounded' alt='image' src='{$path}'/></a>";
                    }

                    $comment = "<div class='grid grid-cols-2 gap-2 pt-2'>{$html}</div>";
                }
                else
                {
                    $comment = nl2br($record->data['comment']);
                }

                $datum = [
                    'recorder' => [
                        'avatar' => null,
                        'name' => null
                    ],
                    'id' => $record->id,
                    'type' => $type,
                    'comment' => $comment,
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

                        if ($recorder->id === $user->id && in_array($record->type, [UserRecordType::USER_MEMO_TEXT_FOR_ADMIN->name, UserRecordType::USER_MEMO_IMAGE_FORM_ADMIN->name]))
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

                if ($record->type === UserRecordType::ROLE_DATA->name)
                {
                    $role = RoleType::getKoreanNames()[$record->data['role']];
                    $datum['comment'] = "[{$role}] {$datum['comment']}";
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
                'type' => ['string', Rule::in(['text', 'image'])],
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

            $type = match ($request->get('type'))
            {
                'text' => UserRecordType::USER_MEMO_TEXT_FOR_ADMIN->name,
                'image' => UserRecordType::USER_MEMO_IMAGE_FORM_ADMIN->name
            };

            $this->userService->createRecord($target->id, $type, $data, $user->id);

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

            $record = $this->recordRepository->findById($request->get('memo_id'));

            if (is_null($record))
            {
                throw new \Exception('NOT FOUND MEMO', 422);
            }

            $user = Auth::user();

            if ($record->recorder_id !== $user->id)
            {
                throw new \Exception('NOT RECORDER', 422);
            }

            if ($record->type === UserRecordType::USER_MEMO_IMAGE_FORM_ADMIN->name)
            {
                $imageIds = json_decode($record->data['comment']);

                foreach ($imageIds as $imageId)
                {
                    $path = $this->fileService->delete($imageId, $user->id);
                }
            }

            $record->delete();

            return $this->jsonResponse('200', 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
