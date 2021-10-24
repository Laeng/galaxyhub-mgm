<?php

namespace App\Action\UserData;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface UserDataContract
{
    public function set(User $user, string $name, mixed $data);
    public function get(User $user, string $name): null|object;
}
