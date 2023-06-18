<?php

namespace App\Services\Steam\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SteamApiClient
{
    protected const BASE_URL = 'https://api.steampowered.com/';

    protected Client $httpClient;

    public function __construct(
        protected string $apiKey,
    ) {
        $this->httpClient = new Client([
            'base_uri' => self::BASE_URL,
        ]);
    }

    /**
     * @param string $steamInterface
     * @param string $interfaceMethod
     * @param string $version
     * @param string $httpMethod
     * @param array $params
     *
     * @return array
     * @throws GuzzleException
     */
    public function request(
        string $steamInterface,
        string $interfaceMethod,
        string $version,
        string $httpMethod = 'GET',
        array $params = []
    ): array {
        $endpoint = implode('/', [$steamInterface, $interfaceMethod, $version]);
        $params['key'] = $this->apiKey;
        $response = $this->httpClient->request($httpMethod, $endpoint, ['query' => $params]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
