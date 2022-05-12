<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum LogType {
    case MISSION_SERVER;

    #[ArrayShape([
        '미션 서버' => "\App\Enums\LogType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            self::MISSION_SERVER->name => '미션 서버'
        ];
    }
}
