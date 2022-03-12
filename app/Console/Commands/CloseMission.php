<?php

namespace App\Console\Commands;

use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use Illuminate\Console\Command;

class CloseMission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:close';

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
    public function handle(MissionRepositoryInterface $missionRepository): int
    {
        $missions = $missionRepository->findByPhase(2)->filter(fn ($v, $k) => $v->closed_at->isPast());

        foreach ($missions as $item)
        {
            $item->phase = 3;
            $item->save();
        }

        return 0;
    }
}
