<?php

use App\Http\Controllers\App\Mission\EditorController;
use App\Http\Controllers\App\Mission\ListController;
use App\Http\Controllers\App\Mission\ReadController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('mission')->name('mission.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::redirect('/', '/app/missions');
        Route::get('/new', [EditorController::class, 'new'])->name('new');

        //AJAX
        Route::post('/create', [EditorController::class, 'create'])->name('create');
        Route::post('/update', [EditorController::class, 'update'])->name('update');
        Route::post('/delete', [EditorController::class, 'delete'])->name('delete');

        //----

        //VIEW
        Route::get('/{missionId}', [ReadController::class, 'read'])->name('read')->whereNumber('missionId');
        Route::get('/{missionId}/edit', [EditorController::class, 'edit'])->name('read.edit')->whereNumber('missionId');
        Route::get('/{missionId}/report', ['', 'report'])->name('read.report')->whereNumber('missionId');

        //AJAX
        Route::post('/{missionId}/refresh', [ReadController::class, 'refresh'])->name('read.refresh');
        Route::post('/{missionId}/participants', [ReadController::class, 'participants'])->name('read.participants');
        Route::post('/{missionId}/process', [ReadController::class, 'process'])->name('read.process');

    });

    Route::prefix('missions')->name('mission.')->middleware(['auth.member:web'])->group(function() {
        //VIEW
        Route::get('/', [ListController::class, 'index'])->name('index');

        //AJAX
        Route::post('/list', [ListController::class, 'list'])->name('list');

    });
});

