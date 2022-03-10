<?php

namespace App\Http\Controllers\App\Updater;

use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class APIController extends Controller
{
    private UpdaterRepositoryInterface $updaterRepository;

    public function __construct(UpdaterRepositoryInterface $updaterRepository)
    {
        $this->updaterRepository = $updaterRepository;
    }

    public function verify(Request $request): JsonResponse
    {
        // 사용 권한이 있다면, code 를 제공하고, 없다면 생성
        try
        {
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

            return Response()->json([
                'result' => $result,
                'code' => $updater->code
            ]);
        }
        catch (Exception $e) {
            return Response()->json([
                'result' => false,
                'code' => ''
            ]);
        }
    }

    public function getUserData(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $updater = $this->updaterRepository->findByCode($request->get('code'));

            if (is_null($updater))
            {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $data = $updater->data;

            if (is_null($data) || count($data) <= 0)
            {
                throw new Exception('DATA IS NULL', 200);
            }

            return Response()->json([
                'result' => true,
                'data' => $data
            ]);
        }
        catch (Exception $e) {
            return Response()->json([
                'result' => false,
                'data' => []
            ]);
        }
    }

    public function setUserData(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required'],
                'data' => ['required']
            ]);

            $updater = $this->updaterRepository->findByCode($request->get('code'));

            if (is_null($updater))
            {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $updater->data = $request->data;
            $updater->save();

            return Response()->json([
                'result' => true,
            ]);

        }
        catch (Exception $e)
        {
            return Response()->json([
                'result' => false,
            ]);
        }
    }

    public function getServerData(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $code = $request->get('code');
            $updater = json_decode(Storage::disk('local')->get('updater/updater.json'), true);
            $canUpload = $code === $updater['token'];

            if (is_null($this->updaterRepository->findByCode($code)) && !$canUpload)
            {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if ($updater['maintenance'])
            {
                throw new Exception('MAINTENANCE', 200);
            }

            $type = $updater['type'];
            $permission = $canUpload ? 'ReadWrite' : 'ReadOnly';


            $data = match($updater['type'])
            {
                'SFTP' => [
                    'ip' => $updater['provider'][$type][$permission]['ip'],
                    'port' => $updater['provider'][$type][$permission]['port'],
                    'id' => $updater['provider'][$type][$permission]['id'],
                    'pw' => $updater['provider'][$type][$permission]['pw'],
                ],
                'S3' => [
                    'url' => $updater['provider'][$type][$permission]['url'],
                    'region' => $updater['provider'][$type][$permission]['region'],
                    'bucket' => $updater['provider'][$type][$permission]['bucket'],
                    'key' => $updater['provider'][$type][$permission]['key'],
                    'secret' => $updater['provider'][$type][$permission]['secret']
                ]
            };

            return Response()->json([
                'result' => true,
                'data' => $data
            ]);
        }
        catch (Exception $e) {
            return Response()->json([
                'result' => false,
                'data' => []
            ]);
        }
    }

    public function ping(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required'],
                'machine_name' => ['string', 'required']
            ]);

            $updater = $this->updaterRepository->findByCode($request->get('code'));

            if (is_null($updater)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if ($updater->machineName !== $request->get('machine_name'))
            {
                $result = false;
            }
            else
            {
                $result = true;
            }


            $userSoftware = $this->query($request->getClientIp(), $request->get('code'), false);

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->setUpdatedAt(now());
            $userSoftware->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => $result
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false
            ]);
        }
    }


}
