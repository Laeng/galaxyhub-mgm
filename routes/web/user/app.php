<?php

use App\Http\Controllers\App\AppController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::name('app.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::get('/', [AppController::class, 'index'])->name('index');

        //AJAX
    });
});

