<?php

namespace App\Enums;

use JetBrains\PhpStorm\Pure;

enum MissionType: int  {
    // array_flip 할 때 value 를 건너 뛰게 설정하게 되면 오류 발생
    case NIGHT_OF_ARMA = 0;
    case MISSION = 1;
    case NON_MISSION_MAKER = 2;
    case BOOTCAMP = 3;
    case SERVICE_RIBBON_TEST = 4;

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

    #[Pure]
    public static function getByRole(string $role): array
    {
        $types = [];

        if (in_array($role, [RoleType::MAKER2->name, RoleType::ADMIN->name]))
        {
            $types += array(
                self::NIGHT_OF_ARMA->value => self::getKoreanNames()[self::NIGHT_OF_ARMA->value]
            );
        }

        if (in_array($role, [RoleType::MAKER1->name, RoleType::MAKER2->name, RoleType::ADMIN->name]))
        {
            $types += array(
                self::MISSION->value => self::getKoreanNames()[self::MISSION->value],
                self::NON_MISSION_MAKER->value => self::getKoreanNames()[self::NON_MISSION_MAKER->value]
            );
        }

        if ($role === RoleType::ADMIN->name)
        {
            $types += array(
                self::BOOTCAMP->value => self::getKoreanNames()[self::BOOTCAMP->value],
                self::SERVICE_RIBBON_TEST->value => self::getKoreanNames()[self::SERVICE_RIBBON_TEST->value]
            );
        }

        return $types;
    }

    public static function needSurvey(): array
    {
        return [
            self::MISSION->value, self::NIGHT_OF_ARMA->value
        ];
    }
}
