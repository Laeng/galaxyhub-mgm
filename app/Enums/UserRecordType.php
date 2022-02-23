<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum UserRecordType {
    case BAN_DATA;
    case USER_MEMO_FOR_ADMIN;
    case USER_PAUSE_ENABLE;
    case USER_PAUSE_DISABLE;
    case ROLE_DATA;
    case STEAM_DATA_SUMMARIES;
    case STEAM_DATA_GAMES;
    case STEAM_DATA_ARMA3;
    case STEAM_DATA_BANS;
    case STEAM_DATA_GROUPS;

    #[ArrayShape([
        '계정 비활성' => "\App\Enums\UserRecordType",
        '관리자 기록' => "\App\Enums\UserRecordType",
        '등급 변경' => "\App\Enums\UserRecordType",
        'STEAM_DATA_SUMMARIES' => "\App\Enums\UserRecordType",
        'STEAM_DATA_GAMES' => "\App\Enums\UserRecordType",
        'STEAM_DATA_ARMA3' => "\App\Enums\UserRecordType",
        'STEAM_DATA_BANS' => "\App\Enums\UserRecordType",
        'STEAM_DATA_GROUPS' => "\App\Enums\UserRecordType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            '계정 비활성' => self::BAN_DATA->name,
            '관리자 기록' => self::USER_MEMO_FOR_ADMIN->name,
            '등급 변경' => self::ROLE_DATA->name,
            'STEAM_DATA_SUMMARIES' => self::STEAM_DATA_SUMMARIES->name,
            'STEAM_DATA_GAMES' => self::STEAM_DATA_GAMES->name,
            'STEAM_DATA_ARMA3' => self::STEAM_DATA_ARMA3->name,
            'STEAM_DATA_BANS' => self::STEAM_DATA_BANS->name,
            'STEAM_DATA_GROUPS' => self::STEAM_DATA_GROUPS->name
        ];
    }
}
