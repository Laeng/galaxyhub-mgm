<?php

namespace App\Http\Controllers\App\Mission;

use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Services\Azure\Contracts\AzureServiceContract;
use App\Services\SSH\Contracts\SSHServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public static array $instances = ['galaxyhub'];

    private AzureServiceContract $azureService;
    private UpdaterRepositoryInterface $updaterRepository;

    public function __construct(AzureServiceContract $azureService, UpdaterRepositoryInterface $updaterRepository)
    {
        $this->azureService = $azureService;
        $this->updaterRepository = $updaterRepository;
    }

    public function deallocate(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'instance_name' => ['required', 'string'],
                'code' => ['uuid', 'required']
            ]);

            $code = $request->get('code');
            $updater = json_decode(Storage::disk('local')->get('updater/updater.json'), true);

            if (is_null($updater))
            {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $instanceName = $request->get('instance_name');

            if (!in_array($instanceName, self::$instances)) throw new \Exception('NOT FOUND', 422);

            $result = $this->azureService->deallocateCompute($instanceName);

            if (!$result)
            {
                throw new \Exception('FAIL', 422);
            }

            return $this->jsonResponse(200, 'SUCCESS', true);
        }
        catch (Exception $e)
        {
            return Response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'code' => ''
            ]);
        }
    }
}
