<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Services\Azure\Contracts\AzureServiceContract;
use App\Services\SSH\Contracts\SSHServiceContract;
use App\Services\SSH\SSHService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ServerController extends Controller
{
    const PASSWORD_LENGTH = 32;

    const CACHE_IP_ADDRESS = 'mission.server.ip_address';
    const CACHE_USERNAME = 'mission.server.username';
    const CACHE_PASSWORD = 'mission.server.password';

    public static array $instances = ['galaxyhub'];

    private AzureServiceContract $azureService;
    private SSHServiceContract $sshService;

    public function __construct(AzureServiceContract $azureService, SSHServiceContract $sshService)
    {
        $this->azureService = $azureService;
        $this->sshService = $sshService;
    }

    public function index(Request $request) : View
    {
        $user = Auth::user();

        if (!$user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
        {
            abort(404);
        }

        return view('app.mission.server.index', [
            'instances' => self::$instances,
            'isAdmin' => $user->hasRole(RoleType::ADMIN->name)
        ]);
    }

    public function status(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
            {
                abort(404);
            }

            $this->jsonValidator($request, [
                'instances' => ['required', 'array'],
            ]);

            $instances = $request->get('instances');

            if (!is_array($instances)) throw new \Exception('VALIDATION FAIL', 422);

            $data = [];

            foreach ($instances as $instanceName)
            {
                $temp = [
                    'code' => -1,
                    'status' => '',
                    'name' => $instanceName,
                    'username' => '',
                    'password' => '',
                    'ip' => '',
                    'online' => false
                ];

                $on = false;

                $instanceView = $this->azureService->getInstanceView($instanceName);
                if (is_null($instanceView)) throw new \Exception('NULL INSTANCE VIEW RESPONSE', 422);

                foreach ($instanceView['statuses'] as $status)
                {
                    switch ($status['code'])
                    {
                        case 'PowerState/deallocated':
                            $this->purgeCache($instanceName);

                            $temp['code'] = 0;
                            $temp['status'] = '종료';
                            break;
                        case 'PowerState/deallocating':
                            $temp['code'] = 2;
                            $temp['status'] = '종료 중';
                            break;
                        case 'PowerState/running':
                            $temp['code'] = 1;
                            $temp['status'] = '실행 중';
                            $on = true;
                            break;
                        case 'PowerState/starting':
                            $temp['code'] = 2;
                            $temp['status'] = '시작 중';
                            break;
                        case 'PowerState/stopped':
                            $temp['code'] = 0;
                            $temp['status'] = '정지';
                            break;
                        case 'PowerState/stopping':
                            $temp['code'] = 2;
                            $temp['status'] = '정지 중';
                            break;
                        case 'PowerState/unknown':
                        default:
                            $temp['code'] = 3;
                            $temp['status'] = '알 수 없음';
                            break;
                    }
                }

                if ($on)
                {
                    if (config('app.debug') === false)
                    {
                        $info = $this->azureService->getCompute($instanceName);
                        if (is_null($info)) throw new \Exception('NULL INFO RESPONSE');

                        $this->setUsername($instanceName, $info['properties']['osProfile']['adminUsername']);

                        $temp['username'] = $this->getUsername($instanceName);
                        $temp['password'] = $this->getPassword($instanceName);
                        $temp['ip'] = $this->getIpAddress($instanceName);

                        if (is_null($temp['password']) || $temp['password'] === '')
                        {
                            $temp['code'] = 2;
                            $temp['status'] = '설정 중';
                            $temp['username'] = '';
                            $temp['password'] = '';
                            $temp['ip'] = '';
                        }
                        else
                        {
                            $temp['online'] = true;
                        }
                    }
                    else
                    {
                        $temp['username'] = config('services.vm.ssh.username');
                        $temp['password'] = config('services.vm.ssh.password') ?? 'Use your private key.';
                        $temp['ip'] = $this->getIpAddress($instanceName);
                        $temp['online'] = true;
                    }
                }

                $data[$instanceName] = $temp;
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'server' => $data,
                'count' => count($data)
            ]);
        }
        catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : [
                'server' => [],
                'count' => 0
            ]);
        }

    }

    public function process(Request $request): JsonResponse
    {
        try
        {
            $user = Auth::user();

            if (!$user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
            {
                abort(404);
            }

            $this->jsonValidator($request, [
                'instance_name' => ['required', 'string'],
                'command' => ['required', 'string']
            ]);

            $instanceName = $request->get('instance_name');

            if (!in_array($instanceName, self::$instances)) throw new \Exception('NOT FOUND', 422);

            switch ($request->get('command'))
            {
                case 'stop':
                    $result = $this->azureService->deallocateCompute($instanceName);

                    if ($result)
                    {
                        $this->purgeCache($instanceName);
                    }
                    break;

                case 'start':
                    $result = $this->azureService->startCompute($instanceName);
                    break;

                case 'restart':
                    $result = $this->azureService->restartCompute($instanceName);
                    break;

                default:
                    $result = false;
                    break;
            }

            if (!$result)
            {
                throw new \Exception('FAIL', 422);
            }

            return $this->jsonResponse(200, 'SUCCESS', $result);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : false);
        }
    }

    public function cost(Request $request): JsonResponse
    {
        try
        {
            $user = Auth::user();

            if (!$user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
            {
                abort(404);
            }

            $budgets = $this->azureService->getBudgets(config('services.azure.budget_name'));

            if (is_null($budgets)) throw new \Exception('NULL BUDGETS RESPONSE', 422);

            return $this->jsonResponse(200, 'SUCCESS', $budgets['properties']['currentSpend']);

        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : [
                "amount" => 0,
                "unit" => '',
            ]);
        }
    }


    public function download(Request $request, string $instanceName): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = Auth::user();

        if (!$user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
        {
            abort(404);
        }

        if (!in_array($instanceName, $this->instances)) return abort(404);

        $instanceView = $this->azureService->getInstanceView($instanceName);
        $pass = false;

        foreach ($instanceView['statuses'] as $status)
        {
            if ($status['code'] == 'PowerState/running') {
                $pass = true;
                break;
            }
        }

        if (!$pass) return abort(404);

        $ip = $this->getIpAddress($instanceName);
        $port = '3389';
        $username = self::getCacheName(self::CACHE_USERNAME, $instanceName);

        $eol = PHP_EOL;
        $time = now()->format('ymdHi');
        $content = "full address:s:{$ip}:{$port}{$eol}prompt for credentials:i:1{$eol}administrative session:i:1{$eol}username=s:{$username}";

        return response($content)->withHeaders([
            'Content-Type' => 'application/rdp',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => "attachment; filename=\"galaxyhub-{$time}.rdp\"",
        ]);
    }

    private function getIpAddress(string $instanceName, bool $cache = true): ?string
    {
        if ($cache && Cache::has(self::getCacheName(self::CACHE_IP_ADDRESS, $instanceName)))
        {
            return Cache::get(self::getCacheName(self::CACHE_IP_ADDRESS, $instanceName));
        }
        else
        {
            $info = $this->azureService->getCompute($instanceName);

            if (is_null($info)) return null;

            $networkInterfaceName = last(explode('/', $info['properties']['networkProfile']['networkInterfaces'][0]['id']));
            $interfaces = $this->azureService->getNetworkInterfaces($networkInterfaceName);

            if (is_null($interfaces)) return null;

            $publicIpAddressName = $interfaces['properties']['ipConfigurations'][0]['properties']['publicIPAddress']['name'];
            $ipAddress = $this->azureService->getPublicIPAddresses($publicIpAddressName);

            if (is_null($ipAddress)) return null;

            if (!array_key_exists('ipAddress', $ipAddress['properties'])) return null;

            $ip = $ipAddress['properties']['ipAddress'];
            Cache::put(self::getCacheName(self::CACHE_IP_ADDRESS, $instanceName), $ip);

            return $ip;
        }
    }

    private function setUsername(string $instanceName, string $username): void
    {
        Cache::put(self::getCacheName(self::CACHE_USERNAME, $instanceName), $username);
    }

    private function getUsername(string $instanceName): ?string
    {
        return Cache::get(self::getCacheName(self::CACHE_USERNAME, $instanceName));
    }

    private function getPassword(string $instanceName, bool $cache = true): ?string
    {
        if ($cache && Cache::has(self::getCacheName(self::CACHE_PASSWORD, $instanceName)))
        {
            return Cache::get(self::getCacheName(self::CACHE_PASSWORD, $instanceName));
        }
        else
        {
            if (Cache::get(self::getCacheName(SSHService::CACHE_ACCOUNT_PASSWORD_LOCK, $instanceName), false) === false)
            {
                $ip = $this->getIpAddress($instanceName);

                if (is_null($ip)) return null;

                $username = $this->getUsername($instanceName);
                $password = Str::random(self::PASSWORD_LENGTH);

                $sshUsername = config('services.vm.ssh.username');
                $sshPassword = config('services.vm.ssh.password');

                $result = $this->sshService->getClient($ip, $sshUsername, $sshPassword)->setAccountPassword($username, $password);

                if ($result)
                {
                    Cache::put(self::getCacheName(self::CACHE_PASSWORD, $instanceName), $password);

                    return $password;
                }
            }

            return null;
        }
    }

    private function purgeCache(string $instanceName): void
    {
        Cache::forget(self::getCacheName(self::CACHE_USERNAME, $instanceName));
        Cache::forget(self::getCacheName(self::CACHE_PASSWORD, $instanceName));
        Cache::forget(self::getCacheName(self::CACHE_IP_ADDRESS, $instanceName));
    }


    private static function getCacheName(string $type, string $name): string
    {
        return "{$type}.{$name}";
    }

}
