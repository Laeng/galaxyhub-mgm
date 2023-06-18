<?php

namespace App\Services\Steam\Client;

class Service
{
    public const NAMESPACE = 'App\\Services\\Steam\\Client\\Services';

    public function __construct(
        protected SteamApiClient $apiClient,
    ) { }

    /**
     * @param string $method
     * @param string $httpMethod
     * @param array $params
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(
        string $method,
        string $httpMethod,
        array $params = [],
    ): array {
        preg_match(
            '%^(I.+)::(.+)(V\d+)$%',
            substr($method, strlen(self::NAMESPACE . '\\')),
            $steamApiMethodParams,
        );
        array_shift($steamApiMethodParams);

        list($steamInterface, $interfaceMethod, $version) = $steamApiMethodParams;

        return $this->apiClient->request($steamInterface, $interfaceMethod, $version, $httpMethod, $params);
    }
}
