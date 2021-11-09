<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
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

    public function jsonResponse(int $status, string $description, mixed $value): JsonResponse
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
}
