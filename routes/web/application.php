<?php

use App\Http\Controllers\Application\AgreementController;
use App\Http\Controllers\Application\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('application')->name('application.')->middleware('web')->group(function() {
    //VIEW
    Route::get('/', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreement.agreements');
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::match(['post', 'get'],'/score', [QuizController::class, 'score'])->name('quiz.score');
    Route::match(['post', 'get'],'/form', [QuizController::class, 'score'])->name('form');


    //AJAX
    Route::post('/agreements/check/account', [AgreementController::class, 'checkAccount'])->name('agreement.check.account');

});
