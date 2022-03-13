<?php

namespace App\Jobs;

use App\Models\Mission;
use App\Services\Discord\Contracts\DiscordServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMissionCreatedMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Mission $mission;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mission $mission)
    {
        $this->mission = $mission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DiscordServiceContract $discordService)
    {
        $discordService->sendMissionCreatedMessage($this->mission);
    }
}
