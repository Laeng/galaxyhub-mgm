<?php

use App\Http\Controllers\Application\AgreementController;
use App\Http\Controllers\Application\FormController;
use App\Http\Controllers\Application\QuizController;
use App\Http\Controllers\File\CkeditorController;
use App\Http\Controllers\File\FilepondController;
use Illuminate\Support\Facades\Route;

Route::prefix('file')->name('file.')->middleware('web')->group(function() {
    //VIEW

    //AJAX
    Route::prefix('upload')->name('upload.')->group(function () {
        Route::post('/filepond/{directory}', [FilepondController::class, 'create'])->name('filepond')->whereAlphaNumeric('directory');
        Route::post('/ckeditor/{directory}', [CkeditorController::class, 'ckeditor_upload'])->name('ckeditor')->whereAlphaNumeric('directory');
    });

    Route::prefix('delete')->name('delete.')->group(function () {
        Route::post('/filepond/{directory}', [FilepondController::class, 'delete'])->name('filepond')->whereAlphaNumeric('directory');
    });

});
