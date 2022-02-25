<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

enum PermissionType {
    case MEMBER;
    case MAKER1;
    case MAKER2;
    case ADMIN;

    #[ArrayShape([
        '멤버' => "\App\Enums\RoleType",
        '임시 메이커' => "\App\Enums\RoleType",
        '정식 메이커' => "\App\Enums\RoleType",
        '관리자' => "\App\Enums\RoleType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            self::MEMBER->name => '멤버',
            self::MAKER1->name => '임시 메이커',
            self::MAKER2->name => '정식 메이커',
            self::ADMIN->name => '관리자'
        ];
    }
}
