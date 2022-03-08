<?php

use App\Http\Controllers\App\AppController;
use App\Http\Middleware\ForbidBannedUser;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::name('app.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::get('/', [AppController::class, 'index'])->middleware([ForbidBannedUser::class])->name('index');
        Route::get('/privacy', [AppController::class, 'privacy'])->name('privacy');
        Route::get('/rules', [AppController::class, 'rules'])->name('rules');

        //AJAX
    });
});

