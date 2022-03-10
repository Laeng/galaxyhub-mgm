<?php

use App\Http\Controllers\App\Account\AccountController;
use App\Http\Controllers\App\Account\AuthenticateController;
use App\Http\Controllers\App\Account\ListController;
use App\Http\Controllers\App\Account\PauseController;
use App\Http\Controllers\App\Updater\UpdaterController;
use App\Http\Middleware\AuthenticateMember;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('account')->name('account.')->middleware(['auth:web'])->group(function () {
        //VIEW
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/authorize/{code}', [UpdaterController::class, 'authorize_code'])->name('authorize')->whereUuid('code');
        Route::get('/leave', [AccountController::class, 'leave'])->name('leave');
        Route::get('/me', [AccountController::class, 'me'])->middleware(AuthenticateMember::class)->name('me');
        Route::get('/missions', [ListController::class, 'mission'])->middleware(AuthenticateMember::class)->name('missions');
        Route::get('/suspended', [AccountController::class, 'suspended'])->name('suspended');
        Route::get('/pause', [PauseController::class, 'pause'])->middleware(AuthenticateMember::class)->name('pause');
        Route::get('/versions', [AccountController::class, 'versions'])->name('versions');


        //AJAX
        Route::post('/delete', [AccountController::class, 'delete'])->name('delete');
        Route::post('/missions/make', [ListController::class, 'make'])->middleware(AuthenticateMember::class)->name('missions.make');
        Route::post('/missions/participate', [ListController::class, 'participate'])->middleware(AuthenticateMember::class)->name('missions.participate');
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
