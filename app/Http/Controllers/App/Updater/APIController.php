<?php

namespace App\Http\Controllers\App\Updater;

use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Services\Github\Contracts\GithubServiceContract;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class APIController extends Controller
{
    private UpdaterRepositoryInterface $updaterRepository;

    public function __construct(UpdaterRepositoryInterface $updaterRepository)
    {
        $this->updaterRepository = $updaterRepository;
    }

    public function verify(Request $request, GithubServiceContract $githubService): JsonResponse
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
            $result = false;
            $message = 'NEED VERIFY';

            $github = $githubService->getLatestRelease('Laeng', 'MGM_UPDATER');

            if (is_null($github))
            {
                throw new Exception('CAN NOT FOUND REPOSITORY');
            }

            $explode = explode('.', $version);
            if (!config('app.debug') && (empty($github['tag_name']) || $github['tag_name'] !== "{$explode[0]}.{$explode[1]}.{$explode[2]}"))
            {
                throw new Exception('VERSION MISMATCH');
            }

            $data = json_decode(Storage::disk('local')->get('updater/updater.json'), true);

            if ($data['maintenance'])
            {
                throw new Exception('MAINTENANCE');
            }

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
            }
            else
            {
                $updater->code = $uuid;
                $updater->save();

                if (!is_null($updater->user_id))
                {
                    $result = true;
                    $message = 'success';
                }
            }

            return Response()->json([
                'result' => $result,
                'message' => $message,
                'code' => $updater->code
            ]);
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return Response()->json([
                'result' => false,
                'message' => $e->getMessage(),
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
                'message' => 'SUCCESS',
                'data' => $data
            ]);
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return Response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => [
                    'path' => ''
                ]
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
                'message' => 'SUCCESS'
            ]);

        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return Response()->json([
                'result' => false,
                'message' => $e->getMessage()
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
                    'type' => 'SFTP',
                    'ip' => $updater['provider'][$type][$permission]['ip'],
                    'port' => $updater['provider'][$type][$permission]['port'],
                    'id' => $updater['provider'][$type][$permission]['id'],
                    'pw' => $updater['provider'][$type][$permission]['pw'],
                ],
                'S3' => [
                    'type' => 'S3',
                    'url' => $updater['provider'][$type][$permission]['url'],
                    'region' => $updater['provider'][$type][$permission]['region'],
                    'bucket' => $updater['provider'][$type][$permission]['bucket'],
                    'key' => $updater['provider'][$type][$permission]['key'],
                    'secret' => $updater['provider'][$type][$permission]['secret']
                ]
            };

            return Response()->json([
                'result' => true,
                'message' => 'SUCCESS',
                'data' => $data
            ]);
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return Response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function ping(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $data = json_decode(Storage::disk('local')->get('updater/updater.json'), true);

            if ($data['maintenance'])
            {
                throw new Exception('MAINTENANCE');
            }

            $updater = $this->updaterRepository->findByCode($request->get('code'));

            if (is_null($updater)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $latest = $this->updaterRepository->findLatestUpdatedByUserId($updater->user_id)->first();

            if ($latest->id === $updater->id)
            {
                $result = true;

                $updater->ip = $request->getClientIp();
                $updater->setUpdatedAt(now());
                $updater->save();
            }
            else
            {
                $result = false;
            }

            return Response()->json([
                'result' => $result,
                'message' => 'SUCCESS'
            ]);

        } catch (Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return Response()->json([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function viewUpdaterIndex(Request $request, string $code): View
    {
        try {
            $updater = $this->updaterRepository->findByCode($code);

            if (is_null($updater)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            return view('app.updater.api.updater-main');

        } catch (Exception $e) {
            return view('app.updater.api.updater-error');
        }
    }


}
