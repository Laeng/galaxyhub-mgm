<?php

namespace App\Services\SSH\Contracts;

interface SSHServiceContract
{
    public function getClient(string $address, string $username, string $password, int $port = 22, int $timeout = 500): SSHServiceContract;
    public function setAccountPassword(string $username, string $password): bool;
}
