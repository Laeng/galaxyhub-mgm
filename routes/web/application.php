<?php

use App\Http\Controllers\Application\AgreementController;
use App\Http\Controllers\Application\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('application')->name('application.')->middleware('web')->group(function() {
    //VIEW
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/score', [QuizController::class, 'score'])->name('quiz.score');


    //AJAX
    Route::post('/agreements/check/account', [AgreementController::class, 'checkAccount'])->name('agreement.check.account');

});
