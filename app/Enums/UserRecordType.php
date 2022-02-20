<?php

namespace App\Enums;

enum UserRecordType {
    case BAN_DATA;
    case ROLE_DATA;
    case STEAM_DATA_SUMMARIES;
    case STEAM_DATA_GAMES;
    case STEAM_DATA_ARMA3;
    case STEAM_DATA_BANS;
    case STEAM_DATA_GROUPS;
}
