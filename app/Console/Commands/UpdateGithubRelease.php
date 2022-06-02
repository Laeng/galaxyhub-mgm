<?php

namespace App\Console\Commands;

use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Services\Github\Contracts\GithubServiceContract;
use Illuminate\Console\Command;

class UpdateGithubRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GithubServiceContract $githubService): int
    {
        $githubService->getLatestRelease('laeng', 'MGM_UPDATER', false, 3600);

        return 0;
    }
}
