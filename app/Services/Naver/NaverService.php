<?php

namespace App\Services\Naver;

use App\Models\UserAccount;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Services\Naver\Contracts\NaverServiceContract;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use function Symfony\Component\String\u;

class NaverService implements NaverServiceContract
{
    private string $stateCacheName = 'naver.state';
    private string $clientKey;
    private string $clientSecret;

    private UserAccountRepositoryInterface $userAccountRepository;

    public function __construct(UserAccountRepositoryInterface $userAccountRepository)
    {
        $this->clientKey = config('services.naver.key');
        $this->clientSecret = config('services.naver.secret');

        $this->userAccountRepository = $userAccountRepository;
    }

    public function getAuthorizeUrl(string $callback): string
    {
        $user = Auth::user();
        $state = Cache::remember("{$this->stateCacheName}.{$user->id}", 60, fn() => Str::random());
        $callback = urlencode($callback);

        return "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id={$this->clientKey}&redirect_uri={$callback}&state={$state}";
    }

    /**
     * @throws Exception
     */
    public function authorizationCode(Request $request, int $userId = null): UserAccount
    {
        $request->validate([
            'code' => ['string'],
            'state' => ['required', 'string'],
            'error' => ['string'],
            'error_description' => ['string']
        ]);

        $user = Auth::user();
        $state = Cache::get("{$this->stateCacheName}.{$user->id}", Str::random());

        if ($request->get('state') !== $state)
        {
            throw new Exception("STATE NOT MATCH");
        }

        $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id={$this->clientKey}&client_secret={$this->clientSecret}&code={$request->get('code')}";
        $client = new Client();

        try {
            $response = json_decode($client->get($url)->getBody()->getContents(), true);
        }
        catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        $accessToken = $response['access_token'];
        $refreshToken = $response['refresh_token'];

        $url = "https://openapi.naver.com/v1/nid/me";
        $client = new Client();

        try {
            $options = [
                RequestOptions::HEADERS => [
                    'Authorization' => "Bearer: {$accessToken}"
                ]
            ];
            $response = json_decode($client->get($url, $options)->getBody()->getContents(), true);
        }
        catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        $account = $this->userAccountRepository->findByAccountId('naver', $response['response']['id'])->first();

        if (is_null($account))
        {
            $account = $this->userAccountRepository->create([
                'user_id' => $userId,
                'provider' => 'naver',
                'account_id' => $response['response']['id'],
                'name' => null,
                'nickname' => $response['response']['nickname'],
                'email' => null,
                'avatar' => $response['response']['profile_image'],
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]);
        }
        else
        {
            $account->nickname = $response['response']['nickname'];
            $account->avatar = $response['response']['profile_image'];
            $account->access_token = $accessToken;
            $account->refresh_token = $refreshToken;
            $account->save();
        }

        return $account;
    }

    /**
     * @throws Exception
     */
    public function refreshToken(): bool
    {
        $account = $this->userAccountRepository->findNaverAccountByUserId(0)->first();

        if (is_null($account)) return false;

        $url = "https://nid.naver.com/oauth2.0/token?grant_type=refresh_token&client_id={$this->clientKey}&client_secret={$this->clientSecret}&refresh_token={$account->refresh_token}";
        $client = new Client();

        try {
            $response = json_decode($client->get($url)->getBody()->getContents(), true);
        }
        catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        $accessToken = $response['access_token'];

        $account->access_token = $accessToken;
        $account->save();

        return true;
    }

    public function writePost(int $cafeId, int $menuId, string $title, string $content): bool
    {
        $account = $this->userAccountRepository->findNaverAccountByUserId(0)->first();

        if (is_null($account)) return false;

        //$cafeId = 17091584;
        $url = "https://openapi.naver.com/v1/cafe/{$cafeId}/menu/{$menuId}/articles";


        $client = new Client();

        try {
            $options = [
                RequestOptions::HEADERS => [
                    'Authorization' => "Bearer {$account->access_token}"
                ],
                RequestOptions::FORM_PARAMS => [
                    'subject' => (urlencode($title)),
                    'content' => (urlencode($content)),
                    'openyn' => false
                ],
            ];

            $client->post($url, $options);
            //$response = json_decode($client->post($url, $options)->getBody()->getContents(), true);
        }
        catch (ClientException $e) {

        }

        return true;
    }



}
