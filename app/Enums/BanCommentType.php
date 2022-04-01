<?php

namespace App\Enums;

enum BanCommentType: string
{
    case USER_PAUSE = '장기 미접속 신청';
    case APPLICATION_QUIZ_FAIL = '가입 퀴즈 불합격';
    case STEAM_PROFILE_STATUS_PRIVATE = '스팀 프로필 비공개';

    public static function getKoreanNames(): array
    {
        return [
            self::USER_PAUSE->name => self::USER_PAUSE->value,
            self::APPLICATION_QUIZ_FAIL->name => self::APPLICATION_QUIZ_FAIL->value,
            self::STEAM_PROFILE_STATUS_PRIVATE->name => self::STEAM_PROFILE_STATUS_PRIVATE->value,
        ];
    }
}
