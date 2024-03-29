<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum UserRecordType {
    case BAN_DATA;
    case UNBAN_DATA;
    case USER_APPLICATION;
    case USER_DELETE;
    case USER_MEMO_TEXT_FOR_ADMIN;
    case USER_MEMO_IMAGE_FORM_ADMIN;
    case USER_PAUSE_ENABLE;
    case USER_PAUSE_DISABLE;
    case ROLE_DATA;
    case STEAM_DATA_SUMMARIES;
    case STEAM_DATA_GAMES;
    case STEAM_DATA_ARMA3;
    case STEAM_DATA_BANS;
    case STEAM_DATA_GROUPS;
    case STEAM_DATA_CHANGE_NICKNAME;

    #[ArrayShape([
        '계정 비활성' => "\App\Enums\UserRecordType",
        '계정 비활성 해제' => "\App\Enums\UserRecordType",
        '유저 데이터 삭제' => "\App\Enums\UserRecordType",
        '가입 신청' => "\App\Enums\UserRecordType",
        '관리자 기록 (텍스트)' => "\App\Enums\UserRecordType",
        '관리자 기록 (이미지)' => "\App\Enums\UserRecordType",
        '장기 미접속 신청' => "\App\Enums\UserRecordType",
        '장기 미접속 해제' => "\App\Enums\UserRecordType",
        '등급 변경' => "\App\Enums\UserRecordType",
        'STEAM_DATA_SUMMARIES' => "\App\Enums\UserRecordType",
        'STEAM_DATA_GAMES' => "\App\Enums\UserRecordType",
        'STEAM_DATA_ARMA3' => "\App\Enums\UserRecordType",
        'STEAM_DATA_BANS' => "\App\Enums\UserRecordType",
        'STEAM_DATA_GROUPS' => "\App\Enums\UserRecordType",
        '스팀 닉네임 변경' => "\App\Enums\UserRecordType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            '계정 비활성' => self::BAN_DATA->name,
            '계정 비활성 해제' => self::UNBAN_DATA->name,
            '유저 데이터 삭제' => self::USER_DELETE->name,
            '가입 신청' => self::USER_APPLICATION->name,
            '관리자 기록 (텍스트)' => self::USER_MEMO_TEXT_FOR_ADMIN->name,
            '관리자 기록 (이미지)' => self::USER_MEMO_IMAGE_FORM_ADMIN->name,
            '장기 미접속 신청' => self::USER_PAUSE_ENABLE->name,
            '장기 미접속 해제' => self::USER_PAUSE_DISABLE->name,
            '등급 변경' => self::ROLE_DATA->name,
            'STEAM_DATA_SUMMARIES' => self::STEAM_DATA_SUMMARIES->name,
            'STEAM_DATA_GAMES' => self::STEAM_DATA_GAMES->name,
            'STEAM_DATA_ARMA3' => self::STEAM_DATA_ARMA3->name,
            'STEAM_DATA_BANS' => self::STEAM_DATA_BANS->name,
            'STEAM_DATA_GROUPS' => self::STEAM_DATA_GROUPS->name,
            '스팀 닉네임 변경' => self::STEAM_DATA_CHANGE_NICKNAME->name
        ];
    }
}
