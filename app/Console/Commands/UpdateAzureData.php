<?php

namespace App\Console\Commands;

use App\Http\Controllers\App\Mission\ServerController;
use App\Jobs\UpdateSteamAccounts;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Services\Azure\Contracts\AzureServiceContract;
use Illuminate\Console\Command;

class UpdateAzureData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'azure:update {type}';

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
    public function handle(AzureServiceContract $azureService): int
    {
        $instances = ServerController::$instances;

        switch ($this->argument('type'))
        {
            case 'instances': // every 1hour
                foreach ($instances as $instance)
                {
                    $azureService->getCompute($instance, false);
                }
                break;

            case 'budges': // every 12hours
                $azureService->getBudgets(config('services.azure.budget_name'), false);
                break;

            case 'usage': // every 4hours
                $azureService->getUsageDetails(false);
                break;

            default:
                break;
        }

        return 0;
    }
}
