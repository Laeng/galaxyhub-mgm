<?php

namespace App\Services\Github\Contracts;

interface GithubServiceContract
{
    public function getLatestRelease(string $accountId, string $repositoryName, bool $cache = true, int $ttl = 60): ?array;
}
