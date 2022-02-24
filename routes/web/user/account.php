<?php

use App\Http\Controllers\App\Account\AccountController;
use App\Http\Controllers\App\Account\AuthenticateController;
use App\Http\Controllers\App\Account\PauseController;
use App\Http\Middleware\AuthenticateMember;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('account')->name('account.')->middleware(['auth:web'])->group(function () {
        //VIEW
        Route::redirect('/', '/app/account/me');
        Route::get('/leave', [AccountController::class, 'leave'])->name('leave');
        Route::get('/me', [AccountController::class, 'me'])->middleware(AuthenticateMember::class)->name('me');
        Route::get('/missions', [AccountController::class, 'me'])->middleware(AuthenticateMember::class)->name('missions');
        Route::get('/suspended', [AccountController::class, 'suspended'])->name('suspended');
        Route::get('/pause', [PauseController::class, 'pause'])->middleware(AuthenticateMember::class)->name('pause');
        Route::get('/versions', [PauseController::class, 'pause'])->name('versions');


        //AJAX
        Route::post('/pause/enable', [PauseController::class, 'enable'])->middleware(AuthenticateMember::class)->name('pause.enable');
        Route::post('/pause/disable', [PauseController::class, 'disable'])->middleware(AuthenticateMember::class)->name('pause.disable');

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
