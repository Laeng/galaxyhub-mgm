<?php

use App\Http\Controllers\App\Mission\EditorController;
use App\Http\Controllers\App\Mission\ListController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('mission')->name('mission.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::redirect('/', '/app/missions');
        Route::get('/new', [EditorController::class, 'new'])->name('new');
        Route::get('/edit/{missionId}', [EditorController::class, 'edit'])->name('edit');
        Route::get('/{missionId}', ['', 'read'])->name('read')->whereNumber('missionId');
        //AJAX

    });

    Route::prefix('missions')->name('mission.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::get('/', [ListController::class, 'index'])->name('index');

        //AJAX


    });
});

