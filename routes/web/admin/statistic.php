<?php

use App\Http\Controllers\App\Admin\Statistic\AddonController;
use App\Http\Controllers\App\Admin\Statistic\MapController;
use App\Http\Controllers\App\Admin\Statistic\MissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('statistic')->name('statistic.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/addon', [AddonController::class, 'addon'])->name('addon');
            Route::get('/map', [MapController::class, 'map'])->name('map');
            Route::get('/mission', [MissionController::class, 'mission'])->name('mission');

            //AJAX
            Route::post('/addon/data', [AddonController::class, 'data'])->name('addon.data');
            Route::post('/map/data', [MapController::class, 'data'])->name('map.data');
            Route::post('/mission/data', [MissionController::class, 'data'])->name('mission.data');
        });


    });
});
