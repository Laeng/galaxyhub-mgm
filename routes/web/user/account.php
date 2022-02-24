<?php

use App\Http\Controllers\App\Account\AccountController;
use App\Http\Controllers\App\Account\AuthenticateController;
use App\Http\Controllers\App\Account\PauseController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('account')->name('account.')->middleware(['auth:web'])->group(function () {
        //VIEW
        Route::redirect('/', '/app/account/me');
        Route::get('/me', [AccountController::class, 'me'])->name('me');
        Route::get('/suspended', [AccountController::class, 'suspended'])->name('suspended');
        Route::get('/pause', [PauseController::class, 'pause'])->name('pause');

        //AJAX
        Route::post('/pause/enable', [PauseController::class, 'enable'])->name('pause.enable');
        Route::post('/pause/disable', [PauseController::class, 'disable'])->name('pause.disable');

    });

    Route::name('auth.')->middleware('web')->group(function() {
        //VIEW
        Route::get('/login', [AuthenticateController::class, 'login'])->name('login');
        Route::get('/login/{provider}', [AuthenticateController::class, 'provider'])->name('login.provider')->whereAlphaNumeric('provider');
        Route::get('/login/{provider}/callback', [AuthenticateController::class, 'callback'])->name('login.provider.callback')->whereAlphaNumeric('provider');
        Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');

        //AJAX

    });
});
