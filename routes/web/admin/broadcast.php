<?php

use App\Http\Controllers\App\Admin\Broadcast\NaverController;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('broadcast')->name('broadcast.')->middleware(['auth.admin:web'])->group(function() {
            Route::prefix('naver')->name('naver.')->middleware(['auth.admin:web'])->group(function() {
                //VIEW
                Route::get('/', [NaverController::class, 'index'])->name('index');
                Route::get('/authorize', [NaverController::class, 'authorizeCode'])->name('authorize');
                Route::get('/callback', [NaverController::class, 'callback'])->name('callback');
                //AJAX

            });

        });

    });
});
