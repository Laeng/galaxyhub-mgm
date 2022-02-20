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
            '멤버' => self::MEMBER,
            '임시 메이커' => self::MAKER1,
            '정식 메이커' => self::MAKER2,
            '관리자' => self::ADMIN
        ];
    }

    #[Pure]
    public static function getByKorean(string $korean): ?PermissionType
    {
        try
        {
            return self::getKoreanNames()[$korean];
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
}
