<?php

namespace App\Http\Controllers\Lounge\Updater;

use App\Http\Controllers\Controller;
use App\Models\UserSoftware;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiUpdaterController extends Controller
{
    public function getS3ReadOnly(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = UserSoftware::where('ip', $request->getClientIp())->where('code', $request->get('code'))->latest()->first();

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if (is_null($userSoftware->data)) {
                throw new Exception('DATA IS NULL', 200);
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => [
                    'key' => config('filesystems.disks.updater.keys.readonly'),
                    'secret' => config('filesystems.disks.updater.secrets.readonly'),
                    'bucket' => config('filesystems.disks.updater.bucket'),
                    'folder' => config('filesystems.disks.updater.folder'),
                    'region' => config('filesystems.disks.updater.region'),
                    'endpoint' => config('filesystems.disks.updater.endpoint'),
                    'path_style' => config('filesystems.disks.updater.use_path_style_endpoint')
                ]
            ]);


        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }

    public function getS3ReadWrite(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = UserSoftware::where('ip', $request->getClientIp())->where('code', $request->get('code'))->latest()->first();

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if (is_null($userSoftware->data)) {
                throw new Exception('DATA IS NULL', 200);
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => [
                    'key' => config('filesystems.disks.updater.keys.readwrite'),
                    'secret' => config('filesystems.disks.updater.secrets.readwrite'),
                    'bucket' => config('filesystems.disks.updater.bucket'),
                    'folder' => config('filesystems.disks.updater.folder'),
                    'region' => config('filesystems.disks.updater.region'),
                    'endpoint' => config('filesystems.disks.updater.endpoint'),
                    'path_style' => config('filesystems.disks.updater.use_path_style_endpoint')
                ]
            ]);


        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }

    private function query(string $ip, string $code): ?UserSoftware
    {
        return UserSoftware::where('updated_at' >= now()->subHours(2))->where('ip', $ip)->where('code', $code)->latest()->first();
    }
}
