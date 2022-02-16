<?php

use App\Http\Controllers\Application\AgreementController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Application\FormController;
use App\Http\Controllers\Application\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('application')->name('application.')->middleware('web')->group(function() {
    //VIEW
    Route::get('/', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreements');
    Route::match(['post', 'get'], '/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::match(['post', 'get'], '/score', [QuizController::class, 'score'])->name('score');
    Route::match(['post', 'get'], '/form', [FormController::class, 'index'])->name('form');
    Route::match(['post'], '/store', [FormController::class, 'store'])->name('store');
    Route::get('/applied', [ApplicationController::class, 'applied'])->name('applied');


    //AJAX
    Route::post('/agreements/check/account', [AgreementController::class, 'checkAccount'])->name('agreement.check.account');

});
