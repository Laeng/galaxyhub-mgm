<?php

namespace App\Console\Commands;

use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Illuminate\Console\Command;

class CleanUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:clean';

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
        $updaters = $updaterRepository->findUnusedOverDay();

        foreach ($updaters as $item)
        {
            $item->delete();
        }

        return 0;
    }
}
