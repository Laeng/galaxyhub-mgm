<?php

namespace App\Services\Discord\Contracts;

use App\Models\Mission;
use App\Models\User;
use App\Repositories\User\UserAccountRepository;
use App\Services\Survey\SurveyService;

interface DiscordServiceContract
{
    public function sendMissionCreatedMessage(Mission $mission): bool;

    public function sendAccountDeleteRequestMassage(SurveyService $surveyService, UserAccountRepository $accountRepository, User $user, string $reason);
}
