<?php

namespace App\Http\Controllers\Staff\User\Memo;

use App\Action\PlayerHistory\PlayerHistory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiUserMemo extends Controller
{
    public function list(Request $request, PlayerHistory $history): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'user_id' => 'int|required'
            ]);

            $data = $history->getModel($history->getIdentifierFromUser($request->get('user_id')))->oldest()->get();
            $items = [];


            foreach ($data as $datum) {
                $item = [
                    'id' => null,
                    'sender' => [
                        'nickname' => null
                    ],
                    'description' => null,
                    'date' => null,
                    'removable' => false
                ];

                $staff = null;
                $staffName = null;
                if (!is_null($datum->staff_id)) {
                    $staff = User::find($datum->staff_id);
                    $staffName = !is_null($staff) ? $staff->nickname : '';
                }

                $item['description'] = "<span class='text-indigo-600 mr-3'>{$history->getName($datum->type)}</span>";

                switch ($datum->type) {
                    case PlayerHistory::TYPE_USER_BANNED:
                    case PlayerHistory::TYPE_USER_UNBANNED:
                    case PlayerHistory::TYPE_APPLICATION_REJECTED:
                    case PlayerHistory::TYPE_APPLICATION_DEFERRED:
                    case PlayerHistory::TYPE_STEAM_DISPLAY_NAME_CHANGED:
                        $item['description'] .= " {$datum->description}";
                        break;

                    case PlayerHistory::TYPE_USER_MEMO:
                        $item['description'] = $datum->description;

                        if (!is_null($staff) && $request->user()->id === $staff->id) {
                            $item['removable'] = true;
                        }
                        break;
                    default:
                        break;
                }

                $item['sender']['nickname'] = $staffName;
                $item['date'] = $datum->created_at->format('Y.m.d H:i');
                $item['id'] = $datum->id;
                $items[] = $item;
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'items' => $items
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), \Str::upper($e->getMessage()), []);
        }

    }

    public function delete(Request $request, PlayerHistory $history): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'user_id' => 'int|required',
                'memo_id' => 'int|required'
            ]);

            $data = $history->getModel($history->getIdentifierFromUser($request->get('user_id')))->where('id', $request->get('memo_id'))->latest()->first();

            if (is_null($data)) {
                throw new Exception('MEMO NOT FOUND', 422);
            }

            // 메모 외에 다른건 허용하지 않기. 한다면 유저 등급도 함께 수정하기.
            if ($data->type !== PlayerHistory::TYPE_USER_MEMO) {
                throw new Exception('CAN NOT REMOVE SYSTEM HISTORY', 422);
            }

            //TODO 상위 관리자 권한은 모두 삭제할 수 있도록 하기
            if ($request->user()->id != $data->staff_id) {
                throw new Exception('PERMISSION NOT FOUND', 422);
            }

            $data->delete();

            return $this->jsonResponse(200, 'SUCCESS', 'OK');

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), \Str::upper($e->getMessage()), []);
        }
    }

    public function create(Request $request, PlayerHistory $history): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'user_id' => 'int|required',
                'content' => 'string|required'
            ]);

            $history->add($history->getIdentifierFromUser($request->get('user_id')), PlayerHistory::TYPE_USER_MEMO, strip_tags($request->get('content')), $request->user());

            return $this->jsonResponse(200, 'SUCCESS', 'OK');

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), \Str::upper($e->getMessage()), []);
        }
    }

}
