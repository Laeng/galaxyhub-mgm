<?php

use App\Http\Controllers\App\Admin\Application\ListController;
use App\Http\Controllers\App\Admin\Application\ReadController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('application')->name('application.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::redirect('/', '/app/admin/applications');
            Route::get('/{userId}', [ReadController::class, 'read'])->name('read')->whereNumber('userId');
            Route::get('/{userId}/games', [ReadController::class, 'games'])->name('read.games')->whereNumber('userId');

            //AJAX
            Route::post('/{userId}/data', [ReadController::class, 'data'])->name('read.data')->whereNumber('userId');
            Route::post('/{userId}/steam', [ReadController::class, 'steam'])->name('read.steam')->whereNumber('userId');
        });

        Route::prefix('applications')->name('application.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/', [ListController::class, 'index'])->name('index');

            //AJAX
            Route::post('/list', [ListController::class, 'list'])->name('index.list');
            Route::post('/process', [ListController::class, 'process'])->name('index.process');
        });
    });
});

