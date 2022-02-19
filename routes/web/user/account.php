<?php

use App\Http\Controllers\App\Account\SuspendController;
use App\Http\Controllers\App\AppController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('account')->name('account.')->middleware(['auth:web'])->group(function () {
        //VIEW
        Route::get('/suspended', [SuspendController::class, '__invoke'])->name('suspended');

        //AJAX

    });
});
