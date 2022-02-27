<?php

namespace App\Services\Github;

use App\Services\Github\Contracts\GithubServiceContract;
use Github\AuthMethod;
use Github\Client as GithubClient;
use Illuminate\Support\Facades\Cache;

class GithubService implements GithubServiceContract
{
    public GithubClient $githubClient;

    public function __construct()
    {
        $github = new GithubClient();
        $github->authenticate(config('services.github.token'), AuthMethod::ACCESS_TOKEN);

        $this->githubClient = $github;
    }

    public function getLatestRelease(string $accountId, string $repositoryName, bool $cache = true, int $ttl = 60): ?array
    {
        $cacheKey = "github-latest-release.{$accountId}.{$repositoryName}";

        $cacheValue = Cache::get($cacheKey);

        if (is_null($cacheValue) || !$cache) {
            $cacheValue = $this->githubClient->api('repo')->releases()->latest($accountId, $repositoryName);

            Cache::put($cacheKey, $cacheValue, $ttl);
        }

        return $cacheValue;
    }
}
