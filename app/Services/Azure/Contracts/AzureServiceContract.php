<?php

namespace App\Services\Azure\Contracts;

use GuzzleHttp\Client;

interface AzureServiceContract
{
    public function getCompute(string $instanceName): ?array;
    public function startCompute(string $instanceName): bool;
    public function deallocateCompute(string $instanceName): bool;
    public function restartCompute(string $instanceName): bool;

    public function getInstanceView(string $instanceName): ?array;
    public function getNetworkInterfaces(string $networkInterfaceName): ?array;
    public function getPublicIPAddresses(string $publicIpAddressName, bool $cache = true): ?array;

    public function getBudgets(string $budgetsName): ?array;
}
