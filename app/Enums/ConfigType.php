<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum ConfigType {
    case MISSION_SERVER_DATA;
    case MISSION_SERVER_SETTING;

    #[ArrayShape([
        '미션 서버' => "\App\Enums\ConfigType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            self::MISSION_SERVER_DATA->name => '미션 서버 데이터',
            self::MISSION_SERVER_SETTING->name => '미션 서버 설정'
        ];
    }
}
