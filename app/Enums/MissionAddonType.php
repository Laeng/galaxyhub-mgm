<?php

namespace App\Enums;

enum MissionAddonType
{
    case RHS;
    case F1;
    case F2;
    case WAR;
    case MAPS;
    case MAPS2;
    case NAVY;
    case ETC;

    public static function getKoreanNames(): array
    {
        return [
            self::RHS->name => 'RHS',
            self::F1->name => 'F1',
            self::F2->name => 'F2',
            self::WAR->name => 'WAR',
            self::MAPS->name => 'MAPS',
            self::MAPS2->name => 'MAPS2',
            self::NAVY->name => 'NAVY',
            self::ETC->name => '기타'
        ];
    }
}

