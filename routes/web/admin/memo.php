<?php

use App\Http\Controllers\App\Admin\Application\ListController;
use App\Http\Controllers\App\Admin\Application\ReadController;
use App\Http\Controllers\App\Memo\MemoController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('memo')->name('memo.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW

            //AJAX
            Route::post('/list', [MemoController::class, 'list'])->name('list');
            Route::post('/create', [MemoController::class, 'create'])->name('create');
            Route::post('/delete', [MemoController::class, 'delete'])->name('delete');
        });
    });
});

