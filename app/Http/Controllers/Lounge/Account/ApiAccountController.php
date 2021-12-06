<?php

namespace App\Http\Controllers\Lounge\Account;

use App\Action\PlayerHistory\PlayerHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAccountController extends Controller
{
    public function leave(Request $request, PlayerHistory $history): JsonResponse
    {
        $user = $request->user();

        if (is_null($user)) {
            return $this->jsonResponse(200, 'NOT FOUND USER', 'FAIL');
        }

        try {
            $identifier = $history->getIdentifierFromUser($user);

            $user->missions()->delete();
            $user->socials()->delete();
            $user->groups()->get()->each(function ($item, $key) {
                $item->reason()->delete();
            });
            $user->groups()->forceDelete(); //soft delete 이기 때문.
            $user->surveys()->delete();
            $user->data()->delete();
            $user->delete();

            $history->add($identifier, PlayerHistory::TYPE_USER_LEAVE, '계정 삭제');

            return $this->jsonResponse(200, 'SUCCESS', 'OK');
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}
