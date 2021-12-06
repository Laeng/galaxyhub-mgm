<?php

namespace App\Http\Controllers\Lounge\Mission;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class ApiMissionController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $step = $request->get('step', 0);
            $limit = $request->get('limit', 20);

            if ($limit < 1 || $limit > 100) $limit = 20;


            $keys = [];
            $items = [];

            //TODO

            return $this->jsonResponse(200, 'OK', [
                'fields' => ['ID', '분류', '시작 시간', '중도 참여', '미션 메이커', '신청'],
                'keys' => $keys,
                'items' => $items,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => 0
                ]
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function create(Request $request): JsonResponse
    {

    }

    public function update(Request $request): JsonResponse
    {

    }

    public function delete(Request $request): JsonResponse
    {

    }

    public function read(Request $request): JsonResponse
    {

    }
}
