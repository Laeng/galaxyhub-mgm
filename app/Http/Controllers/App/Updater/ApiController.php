<?php

namespace App\Http\Controllers\App\Updater;

use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    private UpdaterRepositoryInterface $updaterRepository;

    public function __construct(UpdaterRepositoryInterface $updaterRepository)
    {
        $this->updaterRepository = $updaterRepository;
    }

    public function getS3ReadOnlyAccount(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $updater = $this->updaterRepository->findByCodeAndIp($request->get('code'), $request->getClientIp());

            if (is_null($updater)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if (is_null($updater->data)) {
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

    public function getS3ReadWriteAccount(Request $request): JsonResponse
    {
        /* //애드온 업로더용. 애드온 업로더는 API 사용 안하고 정보를 자체 내장시켜서 배포하기
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $updater = $this->updaterRepository->findByCodeAndIp($request->get('code'), $request->getClientIp());

            if (is_null($updater)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if (is_null($updater->data)) {
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
        */
    }

    public function verify(Request $request): JsonResponse
    {
        // 사용 권한이 있다면, code 를 제공하고, 없다면 생성
        try {
            $this->jsonValidator($request, [
                'version' => ['string', 'required'],
                'machine_name' => ['string', 'required'],
                'machine_version' => ['string', 'required']
            ]);

            $ip = $request->getClientIp();
            $version = $request->get('version');
            $machineName = $request->get('machine_name');
            $machineVersion = $request->get('machine_version');
            $uuid = Str::uuid();
            $result = true;

            $updater = $this->updaterRepository->findByIpMachineNameAndMachineVersion($ip, $machineName, $machineVersion);

            if (is_null($updater))
            {
                $updater = $this->updaterRepository->create([
                    'version' => $version,
                    'ip' => $ip,
                    'machine_name' => $machineName,
                    'machine_version' => $machineVersion,
                    'code' => $uuid
                ]);

                $result = false;
            }
            else
            {
                $updater->code = $uuid;
                $updater->save();

                if (is_null($updater->user_id))
                {
                    $result = false;
                }
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => $result,
                'code' => $updater->code
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'code' => ""
            ]);
        }
    }

    public function getData(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'));

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $data = $userSoftware->getAttributeValue('data');

            if (is_null($data) || count($data) <= 0) {
                throw new Exception('DATA IS NULL', 200);
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => $data
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }

    public function setUserData(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required'],
                'data' => ['required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'));

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->setAttribute('data', $request->get('data'));
            $userSoftware->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
            ]);
        }
    }

    public function ping(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'), false);

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->setUpdatedAt(now());
            $userSoftware->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => null
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }


}
