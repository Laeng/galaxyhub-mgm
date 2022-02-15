<?php

use Illuminate\Support\Facades\Route;

Route::prefix('lounge')->name('lounge.')->middleware('guest')->group(function() {
    //Route::get('/', [AuthenticateController::class, 'index'])->name('welcome');
});
