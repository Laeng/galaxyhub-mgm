<?php

namespace App\Services\Discord;

use App\Enums\MissionType;
use App\Models\Mission;
use App\Models\User;
use App\Repositories\User\UserAccountRepository;
use App\Services\Discord\Contracts\DiscordServiceContract;
use App\Services\Survey\SurveyService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class DiscordService implements DiscordServiceContract
{
    public function __construct()
    {

    }

    public function sendMissionCreatedMessage(?Mission $mission): bool
    {
        if (is_null($mission)) return false;

        $homeUrl = route('app.index');
        $missionUrl = route('mission.read', $mission->id);

        $type = $this->getMissionTypeName($mission->type);
        $body = str_replace('&nbsp;', ' ', strip_tags($mission->body));
        $user = $mission->user()->first();

        try
        {
            $client = new Client();
            $client->post(config('services.discord.webhook.mission'), [
                RequestOptions::JSON => [
                    'username' => $user->name,
                    'avatar_url' => $user->avatar,
                    'type' => "rich",
                    'embeds' => [
                        [
                            'title' => $mission->title,
                            'description' => $body !== "" ? $body : "새로운 {$type} 등록 되었습니다.",
                            'url' => $missionUrl,
                            'color' => '9936498',
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
            Log::error($e);
            return false;
        }

        return true;
    }

    public function sendMissionCanceledMessage(?Mission $mission): bool
    {
        if (is_null($mission)) return false;

        $homeUrl = route('app.index');
        $missionUrl = route('mission.read', $mission->id);

        $type = $this->getMissionTypeName($mission->type);
        $user = $mission->user()->first();

        try
        {
            $client = new Client();
            $client->post(config('services.discord.webhook.mission'), [
                RequestOptions::JSON => [
                    'username' => $user->name,
                    'avatar_url' => $user->avatar,
                    'type' => "rich",
                    'embeds' => [
                        [
                            'title' => $mission->title,
                            'description' => "{$type} 취소 되었습니다.",
                            'url' => $missionUrl,
                            'color' => '9936498',
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
            Log::error($e);
            return false;
        }

        return true;
    }

    private function getMissionTypeName(string $type): string
    {
        return match(MissionType::getKoreanNames()[$type]) {
            '미션' => '미션이',
            '아르마의 밤' => '아르마의 밤이',
            '논미메' => '논미메가',
            '부트캠프' => '부트캠프가',
            '약장 시험' => '약장 시험이'
        };
    }

    public function sendAccountDeleteRequestMassage(SurveyService $surveyService, UserAccountRepository $accountRepository, User $user, string $reason): bool
    {
        try
        {
            $application = $surveyService->getLatestApplicationForm($user->id);
            $steamAccount = $accountRepository->findSteamAccountByUserId($user->id);

            if (is_null($application) || is_null($steamAccount))
            {
                throw new Exception("NOT FOUND INFORMATION - {$user->name}");
            }

            $response = $application->answers()->latest()->get();

            $naverId = '';
            $steamId = $steamAccount->first()->account_id;
            $discordName = '';

            foreach ($response as $item)
            {
                $question = $item->question()->first();
                $value = $item->value;

                if (is_null($question)) continue;

                switch ($question->title) {
                    case '네이버 아이디': $naverId = explode ('@', $value)[0]; break;

                    case '디스코드 사용자명': $discordName = $value; break;
                }
            }


            $homeUrl = route('app.index');

            $client = new Client();
            $client->post(config('services.discord.webhook.admin'), [
                RequestOptions::JSON => [
                    'username' => 'MGM Lounge',
                    'avatar_url' => '',
                    'type' => "rich",
                    'content' => "{$user->name}님의 데이터가 삭제 되었습니다.\n\n```사유: {$reason}\n\n계정 정보\nSTEAM ID: {$steamId}\nSTEAM Nickname: {$user->name}\nNAVER ID: {$naverId}\nDISCORD NAME: {$discordName} ```\n[스팀 프로필](https://steamcommunity.com/profiles/{$steamId}) | [작성 게시글](https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId={$naverId})\n ㅤㅤㅤㅤ",
                ]
            ]);
        }
        catch (GuzzleException $e)
        {
            Log::error($e);
            return false;
        }

        return true;
    }
}
