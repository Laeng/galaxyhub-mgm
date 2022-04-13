<?php

namespace App\Enums;

use function Symfony\Component\String\s;

enum MissionMapType {
    case ALITS;
    case ANIZAY;
    case ARCHIPELAGO;
    case BUKOVINA;
    case BYSTRICA;
    case CHERNARUS;
    case CLAFGHAN;
    case DARIYAH;
    case DESERT;
    case DINGOR;
    case FALLUJAH;
    case FOPOVO;
    case FLORIDAKEY;
    case KUJARI;
    case LINGOR;
    case LIVONIA;
    case LYTHIUM;
    case MINIGATTHON;
    case NEWYORK;
    case PREI_KHMAOCH_LUONG;
    case PORTO;
    case PROVING_GROUNDS;
    case RAHMADI;
    case ROSCHE;
    case RUHA;
    case SAHPUR;
    case SAHRANI;
    case SCOTTISH_HIGHLANDS;
    case SOUTHERN_SAHRANI;
    case STRATIS;
    case SUGARLAKE;
    case SUMMER_CHERNARUS;
    case TAKISTAN;
    case TAKISTAN_MOUNTAINS;
    case TANOA;
    case TEMBELAN;
    case UNITED_SAHRANI;
    case UTES;
    case VIRIRAHTI;
    case WINTER_CHERNARUS;
    case ZARGABAD;
    case ETC;


    public static function getKoreanNames(): array
    {
        return [
            self::ALITS->name => 'Altis',
            self::ANIZAY->name => 'Anizay',
            self::ARCHIPELAGO->name => 'Archipelago',
            self::BUKOVINA->name => 'Bukovina',
            self::BYSTRICA->name => 'Bystrica',
            self::CHERNARUS->name => 'Chernarus',
            self::CLAFGHAN->name => 'Clafghan',
            self::DARIYAH->name => 'Dariyah',
            self::DESERT->name => 'Desert',
            self::DINGOR->name => 'Dingor',
            self::FALLUJAH->name => 'Fallujah',
            self::FLORIDAKEY->name => 'Floridakey',
            self::FOPOVO->name => 'Fapovo',
            self::KUJARI->name => 'Kujari',
            self::LINGOR->name => 'Lingor',
            self::LIVONIA->name => 'Livonia',
            self::LYTHIUM->name => 'Lythium',
            self::MINIGATTHON->name => 'Minihatthan',
            self::NEWYORK->name => 'Newyork',
            self::PORTO->name => 'Porto',
            self::PREI_KHMAOCH_LUONG->name => 'Prei Khmaoch Luong',
            self::PROVING_GROUNDS->name => 'Proving Grounds',
            self::RAHMADI->name => 'Rahmadi',
            self::ROSCHE->name => 'Rosche',
            self::RUHA->name => 'Ruha',
            self::SAHPUR->name => 'Sahpur',
            self::SAHRANI->name => 'Sahrani',
            self::SCOTTISH_HIGHLANDS->name => 'Scottish Highlands',
            self::SOUTHERN_SAHRANI->name => 'Southern Sahrani',
            self::STRATIS->name => 'Stratis',
            self::SUGARLAKE->name => 'Sugarlake',
            self::SUMMER_CHERNARUS->name => 'Summer Chernarus',
            self::TAKISTAN->name => 'Takistan',
            self::TAKISTAN_MOUNTAINS->name => 'Takistan Mountains',
            self::TANOA->name => 'Tanoa',
            self::TEMBELAN->name => 'Tembelan',
            self::UTES->name => 'Utes',
            self::UNITED_SAHRANI->name => 'United Sahrani',
            self::VIRIRAHTI->name => 'Virorahti',
            self::WINTER_CHERNARUS->name => 'WinterChernarus',
            self::ZARGABAD->name => 'Zarabard',
            self::ETC->name => '기타'
        ];
    }
}
