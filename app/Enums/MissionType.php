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

    public static function getTypeByRole(string $role): array
    {
        $types = [];

        if (in_array($role, [RoleType::MAKER2->name, RoleType::ADMIN->name]))
        {
            $types = array_merge($types, [
                self::NIGHT_OF_ARMA
            ]);
        }

        if (in_array($role, [RoleType::MAKER1->name, RoleType::MAKER2->name, RoleType::ADMIN->name]))
        {
            $types = array_merge($types, [
                self::MISSION,
                self::NON_MISSION_MAKER
            ]);
        }

        if ($role === RoleType::ADMIN->name)
        {
            $types = array_merge($types, [
                self::BOOTCAMP,
                self::SERVICE_RIBBON_TEST
            ]);
        }

        return $types;
    }
}
