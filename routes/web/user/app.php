<?php

use App\Http\Controllers\App\AppController;
use App\Http\Middleware\ForbidBannedUser;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::name('app.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::get('/', [AppController::class, 'index'])->middleware([ForbidBannedUser::class])->name('index');

        //AJAX
    });

    Route::name('app.')->group(function() {
        //VIEW
        Route::get('/privacy', [AppController::class, 'privacy'])->name('privacy')->whereNumber('date');
        Route::get('/privacy/{date}', [AppController::class, 'privacy'])->name('privacy.date')->whereNumber('date');
        Route::get('/rules', [AppController::class, 'rules'])->name('rules');

        //AJAX
    });
});

