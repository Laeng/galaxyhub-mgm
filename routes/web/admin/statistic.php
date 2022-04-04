<?php

use App\Http\Controllers\App\Admin\Statistic\AddonController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('statistic')->name('statistic.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/', [AddonController::class, 'addon'])->name('addon');

            //AJAX
            Route::post('/data', [AddonController::class, 'data'])->name('addon.data');
        });


    });
});
