<?php

namespace App\Services\Discord;

use App\Enums\MissionType;
use App\Models\Mission;
use App\Services\Discord\Contracts\DiscordServiceContract;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class DiscordService implements DiscordServiceContract
{
    private Client $client;
    private string $webhook;

    public function __construct()
    {
        $this->client = new Client();
        $this->webhook = config('services.discord.webhook');
    }

    public function sendMissionCreatedMessage(?Mission $mission): bool
    {
        if (is_null($mission)) return false;

        $homeUrl = route('app.index');
        $missionUrl = route('mission.read', $mission->id);

        $type = MissionType::getKoreanNames()[$mission->type];

        $type = match($type) {
            '미션' => '미션이',
            '아르마의 밤' => '아르마의 밤이',
            '논미메' => '논미메가',
            '부트캠프' => '부트캠프가',
            '약장 시험' => '약장 시험이'
        };

        try
        {
            $this->client->post($this->webhook, [
                RequestOptions::JSON => [
                    'name' => "MGM 라운지",
                    'avatar_url' => 'https://mgm.galaxyhub.kr/images/mgm_300x300.png',
                    'type' => "rich",
                    'embeds' => [
                        [
                            'title' => $mission->title,
                            'description' => "새로운 {$type} 등록 되었습니다.",
                            'url' => $missionUrl,
                            'color' => '5195493',
                            'author' => [
                                'name' => 'MGM 라운지',
                                'url' => $homeUrl
                            ],
                            'timestamp' => now()->toIso8601String()
                        ]
                    ]
                ]
            ]);
        }
        catch (GuzzleException $e)
        {

        }

        return true;
    }
}

