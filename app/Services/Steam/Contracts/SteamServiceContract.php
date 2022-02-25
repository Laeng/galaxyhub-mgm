<?php

namespace App\Services\Steam\Contracts;

/**
 * Interface SteamServiceContract
 * @package App\Services\Contracts
 */
interface SteamServiceContract
{
    public function getOwnedGames(int $steamId, bool $includeAppInfo = true, bool $includePlayedFreeGames = false, array $appIdsFilter = []): array;

    public function getPlayerSummaries(int $steamId): array;

    public function getPlayerBans(int $steamId): array;

    public function getGroupSummary(int $steamGroupId): array;
}
