<?php

use App\Http\Controllers\App\File\CkeditorController;
use App\Http\Controllers\App\File\FilepondController;
use App\Http\Controllers\App\Updater\UpdaterController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('updater')->name('updater.')->middleware('auth.member:web')->group(function() {
        //VIEW
        Route::get('/download', [UpdaterController::class, 'download'])->name('download');
        Route::get('/', [UpdaterController::class, 'index'])->name('index');

        //AJAX

    });
});

