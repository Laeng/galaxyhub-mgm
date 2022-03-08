<?php

use App\Http\Controllers\App\File\CkeditorController;
use App\Http\Controllers\App\File\FilepondController;
use App\Http\Controllers\App\Updater\UpdaterController;
use App\Http\Middleware\ForbidBannedUser;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('updater')->name('updater.')->middleware(['auth.member:web', ForbidBannedUser::class])->group(function() {
        //VIEW
        Route::get('/', [UpdaterController::class, 'index'])->name('index');
        Route::get('/download/{userId}', [UpdaterController::class, 'download'])->name('download')->whereNumber('userId');
        Route::get('/authorize/{code}', [UpdaterController::class, 'authorize_code'])->name('authorize')->whereUuid('code');

        //AJAX
        Route::post('/release', [UpdaterController::class, 'release'])->name('release');
    });
});
