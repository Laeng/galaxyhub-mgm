<?php

use App\Http\Controllers\App\Admin\Application\ListController;
use App\Http\Controllers\App\Admin\Application\ReadController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('application')->name('application.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::redirect('/', '/app/admin/application');
            Route::get('/{userId}', [ReadController::class, 'read'])->name('read')->whereNumber('userId');

            //AJAX
        });

        Route::prefix('applications')->name('application.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/', [ListController::class, 'index'])->name('index');

            //AJAX
            Route::post('/data', [ListController::class, 'data'])->name('index.data');
            Route::post('/process', [ListController::class, 'process'])->name('index.process');
        });
    });
});

