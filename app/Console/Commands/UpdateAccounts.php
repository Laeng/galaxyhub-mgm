<?php

namespace App\Console\Commands;

use App\Jobs\UpdateSteamAccounts;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Illuminate\Console\Command;

class UpdateAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:update {provider}';

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
    public function handle(UpdaterRepositoryInterface $updaterRepository): int
    {
        switch ($this->argument('provider'))
        {
            case 'steam':
                UpdateSteamAccounts::dispatch();
                break;
            default:
                break;
        }

        return 0;
    }
}
