<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;

enum BadgeType
{
    case BOOTCAMP_GRADUATE;
    case JTAC;
    case MEDIC;
    case MISFIT;
    case MISSION_MAKER;
    case ONE_OF_ALL;
    case SENIOR_MEMBER;
    case SQUID_LEADER;
    case STEELRAIN;
    case WARPIG;
    case STAFF;
    case MANAGER;


    #[ArrayShape([
        '부트캠프 수료' => "\App\Enums\BadgeType",
        'JTAC' => "\App\Enums\BadgeType",
        '메딕' => "\App\Enums\BadgeType",
        '미스핏' => "\App\Enums\BadgeType",
        '미션 메이커' => "\App\Enums\BadgeType",
        'One of All' => "\App\Enums\BadgeType",
        '시니어 멤버' => "\App\Enums\BadgeType",
        '분대장' => "\App\Enums\BadgeType",
        '스틸레인' => "\App\Enums\BadgeType",
        '워피그' => "\App\Enums\BadgeType",
        '스탭' => "\App\Enums\BadgeType",
        '매니저' => "\App\Enums\BadgeType"
    ])]
    public static function getKoreanNames(): array
    {
        return [
            self::BOOTCAMP_GRADUATE->name => '부트캠프 수료',
            self::JTAC->name => 'JTAC',
            self::MEDIC->name => '메딕',
            self::MISFIT->name => '미스핏',
            self::MISSION_MAKER->name => '미션 메이커',
            self::ONE_OF_ALL->name => 'One of All',
            self::SENIOR_MEMBER->name => '시니어 멤버',
            self::SQUID_LEADER->name => '분대장',
            self::STEELRAIN->name => '스틸레인',
            self::WARPIG->name => '워피그',
            self::STAFF->name => '스탭',
            self::MANAGER->name => '매니저'
        ];
    }
}
