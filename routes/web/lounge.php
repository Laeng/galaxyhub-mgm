<?php

use App\Http\Controllers\Lounge\LoungeController;
use Illuminate\Support\Facades\Route;

Route::prefix('lounge')->name('lounge.')->middleware(['auth.member:web'])->group(function() {
    //VIEW
    Route::get('/', [LoungeController::class, 'index'])->name('welcome');

    //AJAX
});
