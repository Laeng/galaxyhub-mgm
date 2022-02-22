<?php

use App\Http\Controllers\App\Account\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('account')->name('account.')->middleware(['auth:web'])->group(function () {
        //VIEW
        Route::get('/suspended', [AuthenticateController::class, 'suspended'])->name('suspended');

        //AJAX

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
