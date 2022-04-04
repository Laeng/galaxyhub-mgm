<?php

use App\Http\Controllers\App\Admin\Mission\SurveyController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('mission')->name('mission.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/survey', [SurveyController::class, 'survey'])->name('survey');

            //AJAX
        });


    });
});
