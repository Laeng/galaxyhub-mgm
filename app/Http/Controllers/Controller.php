<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws \Exception
     */
    public function jsonValidator(\Request|\Illuminate\Http\Request $request, array $rules): void
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new \Exception('Validation failed', 422);
        }
    }

    public function jsonResponse(int|string $status, string $description, mixed $value): JsonResponse
    {
        if (!array_key_exists($status, Response::$statusTexts)) {
            $status = 500;
        }

        return response()->json(['status' => $status, 'description' => $description, 'data' => $value], ($status == 0) ? 500 : $status);
    }
}
