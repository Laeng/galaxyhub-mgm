<?php

namespace App\Enums;

enum MissionType:int  {
    case NIGHT_OF_ARMA = 0;
    case MISSION = 1;
    case NON_MISSION_MAKER = 2;
    case BOOTCAMP = 10;
    case SERVICE_RIBBON_TEST = 11;

    public static function getKoreanNames(): array
    {
        return [
            self::NIGHT_OF_ARMA->value => '아르마의 밤',
            self::MISSION->value => '미션',
            self::NON_MISSION_MAKER->value => '논미메',
            self::BOOTCAMP->value => '부트캠프',
            self::SERVICE_RIBBON_TEST->value => '약장 시험',
        ];
    }
}
