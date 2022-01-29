<?php

use App\Models\Mission;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mission:update', function () {
    $now = now();

    // 출석 마감 시키기
    Mission::where('phase', '2')->where('closed_at', '<=', $now)->oldest()->each(function ($i, $k) {
        $i->phase = 3;
        $i->save();
    });

    // 시작 예정 일로부터 2일이상 방치된 미션들 정리 시키기
    Mission::whereBetween('phase', [0, 1])->where('expected_at', '<=', $now->subDays(2))->oldest()->each(function ($i, $k) {
        $i->phase = -1;
        $i->save();
    });
});
