<?php

use App\Http\Controllers\App\Admin\User\ListController;
use App\Http\Controllers\App\Admin\User\ReadController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('user')->name('user.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::redirect('/', '/app/admin/users');
            Route::get('/{userId}', [ReadController::class, 'read'])->name('read')->whereNumber('userId');

            //AJAX
            //Route::post('/{userId}/data', [ReadController::class, 'data'])->name('read.data')->whereNumber('userId');
        });

        Route::prefix('users')->name('user.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/', [ListController::class, 'index'])->name('index');

            //AJAX
            Route::post('/list', [ListController::class, 'list'])->name('index.list');
            Route::post('/process', [ListController::class, 'process'])->name('index.process');
        });
    });
});
