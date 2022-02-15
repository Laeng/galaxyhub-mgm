<?php

namespace App\Services\Auth\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface AuthServiceContract
 * @package App\Services\Contracts
 */
interface AuthBaseServiceContract
{
    public function create(array $attributes): ?Model;
}
