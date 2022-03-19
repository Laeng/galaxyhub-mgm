<?php

namespace App\Services\Naver\Contracts;

use App\Models\UserAccount;
use Illuminate\Http\Request;

interface NaverServiceContract
{
    public function getAuthorizeUrl(string $callback): string;

    public function authorizationCode(Request $request, int $userId = null): UserAccount;

    public function refreshToken(): bool;

    public function writePost(int $cafeId, int $menuId, string $title, string $content): bool;
}
