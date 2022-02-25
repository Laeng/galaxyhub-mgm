<?php

namespace App\Enums;

enum MissionPhaseType: int {
    case RECRUITING = 0;
    case IN_PROGRESS = 1;
    case IN_ATTENDANCE = 2;
    case END = 3;
    case CANCEL = -1;

    public static function getKoreanNames(): array
    {
        return [
            self::RECRUITING->value => '모집 중',
            self::IN_PROGRESS->value => '진행 중',
            self::IN_ATTENDANCE->value => '출석 중',
            self::END->value => '종료',
            self::CANCEL->value => '취소'
        ];
    }
}
