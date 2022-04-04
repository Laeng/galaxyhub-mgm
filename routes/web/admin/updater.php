<?php

use App\Http\Controllers\App\Admin\Updater\UpdaterController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('updater')->name('updater.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/users', [UpdaterController::class, 'users'])->name('users');

            //AJAX
            Route::post('/users/data', [UpdaterController::class, 'data'])->name('users.data');
        });


    });
});
