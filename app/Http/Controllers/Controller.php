<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Models\UserGroup;
use App\Models\UserSoftware;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function jsonResponse(int|string $status, string $description, mixed $value): JsonResponse
    {
        if (!array_key_exists($status, Response::$statusTexts)) {
            $status = 500;
        }

        return response()->json(['status' => $status, 'description' => $description, 'data' => $value], ($status == 0) ? 500 : $status);
    }

    /**
     * @throws Exception
     */
    public function jsonValidator(Request|\Illuminate\Http\Request $request, array $rules): void
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new Exception('Validation failed', 422);
        }
    }

    public function getPaginationStep(int $step, int $limit, int $total): int
    {
        if ($step >= 0) {
            $quotient = intdiv($total, $limit);
            if ($quotient <= $step) {
                $step = $quotient - 1; //step 값은 0부터 시작하기 떄문에 1를 빼준다.

                if ($total % $limit > 0) {
                    $step += 1;
                }
            }
        } else {
            $step = 0;
        }

        return $step;
    }
}
