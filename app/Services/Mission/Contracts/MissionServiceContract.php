<?php

namespace App\Services\Mission\Contracts;

interface MissionServiceContract
{
    public function addParticipant(int $missionId, int $userId, bool $isMaker = false): bool;

    public function removeParticipant(int $missionId, int $userId): bool;

}
