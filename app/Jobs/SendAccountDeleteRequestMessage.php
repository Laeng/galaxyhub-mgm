<?php

namespace App\Jobs;

use App\Enums\UserRecordType;
use App\Models\User;
use App\Repositories\User\UserAccountRepository;
use App\Services\Discord\Contracts\DiscordServiceContract;
use App\Services\Survey\SurveyService;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAccountDeleteRequestMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;
    private string $reason;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserServiceContract $userService, DiscordServiceContract $discordService, UserAccountRepository $accountRepository, SurveyService $surveyService)
    {
        Log::error('send leave user message');
        $discordService->sendAccountDeleteRequestMassage($surveyService, $accountRepository, $this->user, $this->reason);

        $userService->createRecord($this->user->id, UserRecordType::USER_DELETE->name, [
            'comment' => $this->reason
        ]);

        $userService->delete($this->user->id);
    }
}
