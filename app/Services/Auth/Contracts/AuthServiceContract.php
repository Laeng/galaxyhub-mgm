<?php

namespace App\Services\Auth\Contracts;

use App\Models\User;

/**
 * Interface AuthServiceContract
 * @package App\Services\Contracts
 */
interface AuthServiceContract
{
    public function create(array $attributes): ?User;
}
