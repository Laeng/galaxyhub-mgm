<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->middleware('web')->group(function() {
    Route::get('/login', [AuthenticateController::class, 'login'])->name('login');
    Route::get('/login/{provider}', [AuthenticateController::class, 'provider'])->name('login.provider')->whereAlphaNumeric('provider');
    Route::get('/login/{provider}/callback', [AuthenticateController::class, 'callback'])->name('login.provider.callback')->whereAlphaNumeric('provider');
    Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');
});
