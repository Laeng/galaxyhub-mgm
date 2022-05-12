<?php

namespace App\Services\Azure;

use App\Services\Azure\Contracts\AzureServiceContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AzureService implements AzureServiceContract
{
    const CACHE_AZURE_ACCESS_TOKEN = 'services.azure.access_token';
    const CACHE_AZURE_API_GET_COMPUTE = 'services.azure.api.get.compute';
    const CACHE_AZURE_API_INSTANCE_VIEW_DATA = 'services.azure.api.instance_view.data';
    const CACHE_AZURE_API_INSTANCE_VIEW_TIMER = 'services.azure.api.instance_view.timer';

    public function getCompute(string $instanceName, bool $cache = true): ?array
    {
        try {
            if ($cache && Cache::has(self::getCacheName(self::CACHE_AZURE_API_GET_COMPUTE, $instanceName)))
            {
                $data = Cache::get(self::getCacheName(self::CACHE_AZURE_API_GET_COMPUTE, $instanceName));

                return json_decode($data, true);
            }
            else
            {
                $client = $this->getClient();
                $result = $client->get("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}", [
                    'query' => [
                        'api-version' => '2021-11-01'
                    ],
                ]);

                if ($result->getStatusCode() == 200)
                {
                    $data = $result->getBody()->getContents();

                    Cache::put(self::getCacheName(self::CACHE_AZURE_API_GET_COMPUTE, $instanceName), $data, now()->addHour());

                    return json_decode($data, true);
                }
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function startCompute(string $instanceName): bool
    {
        try {
            $client = $this->getClient();
            $result = $client->post("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}/start", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 202)
            {
                return true;
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function deallocateCompute(string $instanceName): bool
    {
        try {
            $client = $this->getClient();
            $result = $client->post("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}/deallocate", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 202)
            {
                return true;
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function restartCompute(string $instanceName): bool
    {
        try {
            $client = $this->getClient();
            $result = $client->post("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}/restart", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 202)
            {
                return true;
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function getInstanceView(string $instanceName): ?array
    {
        try {
            $instanceViewData = self::getCacheName(self::CACHE_AZURE_API_INSTANCE_VIEW_DATA, $instanceName);
            $instanceViewTimer = self::getCacheName(self::CACHE_AZURE_API_INSTANCE_VIEW_TIMER, $instanceName);

            if (Cache::has($instanceViewData) && Cache::has($instanceViewTimer))
            {
                if (Carbon::createFromTimestamp(Cache::get($instanceViewTimer))->timestamp > now()->timestamp)
                {
                    return json_decode(Cache::get($instanceViewData), true);
                }
                else
                {
                    Cache::forget($instanceViewData);
                    Cache::forget($instanceViewTimer);
                }

            }

            $client = $this->getClient();
            $result = $client->get("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}/instanceView", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                //ref: https://docs.microsoft.com/ko-kr/rest/api/compute/virtual-machines/instance-view

                $data = $result->getBody()->getContents();

                Cache::put($instanceViewData, $data);
                Cache::put($instanceViewTimer, (string) now()->addSeconds(5)->timestamp);

                return json_decode($data, true);
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e);
        }

        return null;
    }

    public function getNetworkInterfaces(string $networkInterfaceName, bool $cache = true): ?array
    {
        try {
            $client = $this->getClient();
            $result = $client->get("{$this->url()}/Microsoft.Network/networkInterfaces/{$networkInterfaceName}", [
                'query' => [
                    'api-version' => '2021-08-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();

                return json_decode($data, true);
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function getPublicIPAddresses(string $publicIpAddressName, bool $cache = true): ?array
    {
        try {
            $client = $this->getClient();
            $result = $client->get("{$this->url()}/Microsoft.Network/publicIPAddresses/{$publicIpAddressName}", [
                'query' => [
                    'api-version' => '2021-05-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();

                return json_decode($data, true);
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function getBudgets(string $budgetsName): ?array
    {
        try {
            $subscriptionId = config('services.azure.subscription_id');
            $client = $this->getClient();

            $result = $client->get("https://management.azure.com/subscriptions/{$subscriptionId}/providers/Microsoft.Consumption/budgets/{$budgetsName}", [
                'query' => [
                    'api-version' => '2021-10-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                //ref: https://docs.microsoft.com/ko-kr/rest/api/consumption/budgets/get

                return json_decode($result->getBody()->getContents(), true);
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return null;
    }

    private function getClient(): Client
    {
        $config = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->getAccessToken()}",
                'Content-Type' => 'application/json',
            ],
        ];

        return new client($config);
    }

    private function getAccessToken(): ?string
    {
        try {
            if (Cache::has(self::CACHE_AZURE_ACCESS_TOKEN))
            {
                return Cache::get(self::CACHE_AZURE_ACCESS_TOKEN);
            }
            else
            {
                $client = new Client();

                $tenantId = config('services.azure.tenant_id');
                $response = $client->post("https://login.microsoftonline.com/{$tenantId}/oauth2/token", [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => config('services.azure.key'),
                        'client_secret' => config('services.azure.secret'),
                        'resource' => 'https://management.core.windows.net/'
                    ]
                ]);

                $result = json_decode($response->getBody()->getContents(), true);

                if (!array_key_exists('access_token', $result))
                {
                    throw new \Exception('NOT FOUND ACCESS TOKEN');
                }

                Cache::put(self::CACHE_AZURE_ACCESS_TOKEN, $result['access_token'], now()->addSeconds((int) $result['expires_in']));

                return $result['access_token'];
            }
        }
        catch (GuzzleException | \Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    private function url(): string
    {
        $subscriptionId = config('services.azure.subscription_id');
        $resourceGroupName = config('services.azure.resource_group_name');

        return "https://management.azure.com/subscriptions/{$subscriptionId}/resourceGroups/{$resourceGroupName}/providers";
    }

    private static function getCacheName(string $type, string $name): string
    {
        return "{$type}.{$name}";
    }
}
