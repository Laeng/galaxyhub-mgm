<?php

use App\Http\Controllers\App\File\CkeditorController;
use App\Http\Controllers\App\File\FilepondController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('file')->name('file.')->middleware('auth:web')->group(function() {
        //VIEW

        //AJAX
        Route::prefix('upload')->name('upload.')->group(function () {
            Route::post('/filepond/{directory}', [FilepondController::class, 'create'])->name('filepond')->whereAlphaNumeric('directory');
            Route::post('/ckeditor/{directory}', [CkeditorController::class, 'create'])->name('ckeditor')->whereAlphaNumeric('directory');
        });

        Route::prefix('delete')->name('delete.')->group(function () {
            Route::post('/filepond/{directory}', [FilepondController::class, 'delete'])->name('filepond')->whereAlphaNumeric('directory');
            Route::post('/ckeditor/{directory}', [CkeditorController::class, 'delete'])->name('ckeditor')->whereAlphaNumeric('directory');
        });

        Route::prefix('get')->name('get.')->group(function () {
            Route::post('/filepond', [FilepondController::class, 'read'])->name('filepond')->whereAlphaNumeric('directory');
        });
    });
});

