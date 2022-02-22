<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum RoleType {
    case APPLY;
    case DEFER;
    case REJECT;
    case MEMBER;
    case MAKER1;
    case MAKER2;
    case ADMIN;

    #[ArrayShape([
        '가입 신청' => "\App\Enums\RoleType",
        '가입 보류' => "\App\Enums\RoleType",
        '가입 거절' => "\App\Enums\RoleType",
        '멤버' => "\App\Enums\RoleType",
        '임시 메이커' => "\App\Enums\RoleType",
        '정식 메이커' => "\App\Enums\RoleType",
        '관리자' => "\App\Enums\RoleType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            self::APPLY->name => '가입 신청',
            self::DEFER->name => '가입 보류',
            self::REJECT->name => '가입 거절',
            self::MEMBER->name => '멤버',
            self::MAKER1->name => '임시 메이커',
            self::MAKER2->name => '정식 메이커',
            self::ADMIN->name => '관리자'
        ];
    }
}
