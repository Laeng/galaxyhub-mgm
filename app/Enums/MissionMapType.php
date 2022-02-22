<?php

namespace App\Enums;

enum MissionMapType {
    case ALITS;
    case STRATIS;
    case TANOA;
    case CHERNARUS;
    case ZARGABAD;
    case FALLUJAH;
    case ETC;

    public static function getKoreanNames(): array
    {
        return [
            self::ALITS->name => '알티스',
            self::STRATIS->name => '스트라티스',
            self::TANOA->name => '타노아',
            self::CHERNARUS->name => '체르나러스',
            self::ZARGABAD->name => '자가바드',
            self::FALLUJAH->name => '팔루자',
            self::ETC->name => '기타',
        ];
    }
}
