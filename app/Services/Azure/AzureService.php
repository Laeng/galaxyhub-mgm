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
    const CACHE_AZURE_API_COMPUTE = 'services.azure.api.compute';
    const CACHE_AZURE_API_BUDGETS = 'services.azure.api.budgets';
    const CACHE_AZURE_API_USAGE_DETAILS = 'services.azure.api.usage_details';
    const CACHE_AZURE_API_INSTANCE_VIEW = 'services.azure.api.instance_view';

    public function getCompute(string $instanceName, bool $cache = true): ?array
    {
        try {
            $cacheName = self::getCacheName(self::CACHE_AZURE_API_COMPUTE, $instanceName);

            if ($cache && Cache::has($cacheName))
            {
                return json_decode(Cache::get($cacheName), true);
            }

            $client = $this->getClient();
            $result = $client->get("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();
                Cache::put($cacheName, $data, now()->addHours(2));

                return json_decode($data, true);
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

    public function getInstanceView(string $instanceName, bool $cache = true): ?array
    {
        try {
            $cacheName = self::getCacheName(self::CACHE_AZURE_API_INSTANCE_VIEW, $instanceName);

            if ($cache && Cache::has($cacheName))
            {
                return json_decode(Cache::get($cacheName), true);
            }

            $client = $this->getClient();
            $result = $client->get("{$this->url()}/Microsoft.Compute/virtualMachines/{$instanceName}/instanceView", [
                'query' => [
                    'api-version' => '2021-11-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();
                Cache::put($cacheName, $data, now()->addSeconds(2));

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

    public function getBudgets(string $budgetsName, bool $cache = true): ?array
    {
        try {
            $cacheName = self::getCacheName(self::CACHE_AZURE_API_BUDGETS, $budgetsName);

            if ($cache && Cache::has($cacheName))
            {
                return json_decode(Cache::get($cacheName), true);
            }


            $subscriptionId = config('services.azure.subscription_id');
            $client = $this->getClient();

            $result = $client->get("https://management.azure.com/subscriptions/{$subscriptionId}/providers/Microsoft.Consumption/budgets/{$budgetsName}", [
                'query' => [
                    'api-version' => '2021-10-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();
                Cache::put($cacheName, $data, now()->addHours(12));

                return json_decode($data, true);
            }
        }
        catch (GuzzleException|\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function getUsageDetails(bool $cache = true): ?array
    {
        try {
            $cacheName = self::CACHE_AZURE_API_USAGE_DETAILS;

            if ($cache && Cache::has($cacheName))
            {
                return json_decode(Cache::get($cacheName), true);
            }

            $subscriptionId = config('services.azure.subscription_id');
            $client = $this->getClient();

            $result = $client->get("https://management.azure.com/subscriptions/{$subscriptionId}/providers/Microsoft.Consumption/usageDetails", [
                'query' => [
                    'api-version' => '2021-10-01'
                ],
            ]);

            if ($result->getStatusCode() == 200)
            {
                $data = $result->getBody()->getContents();
                Cache::put($cacheName, $data, now()->addHours(24));

                return json_decode($data, true);
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
