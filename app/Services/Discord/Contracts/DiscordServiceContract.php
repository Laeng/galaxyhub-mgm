<?php

namespace App\Services\Discord\Contracts;

use App\Models\Mission;

interface DiscordServiceContract
{
    public function sendMissionCreatedMessage(Mission $mission): bool;
}
