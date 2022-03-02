<?php

use App\Http\Controllers\App\Mission\AttendController;
use App\Http\Controllers\App\Mission\EditorController;
use App\Http\Controllers\App\Mission\ListController;
use App\Http\Controllers\App\Mission\ReadController;
use App\Http\Controllers\App\Mission\SurveyController;
use App\Http\Middleware\ForbidBannedUser;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('mission')->name('mission.')->middleware(['auth.member:web', ForbidBannedUser::class])->group(function() {
        //VIEW
        Route::redirect('/', '/app/missions');
        Route::get('/new', [EditorController::class, 'new'])->name('new');

        //AJAX
        Route::post('/create', [EditorController::class, 'create'])->name('create');
        Route::post('/delete', [ReadController::class, 'delete'])->name('delete');
        Route::post('/update', [EditorController::class, 'update'])->name('update');

        //----

        //VIEW
        Route::get('/{missionId}', [ReadController::class, 'read'])->name('read')->whereNumber('missionId');
        Route::match(['get', 'post'],'/{missionId}/attend', [AttendController::class, 'attend'])->name('read.attend')->whereNumber('missionId');
        Route::get('/{missionId}/edit', [EditorController::class, 'edit'])->name('read.edit')->whereNumber('missionId');
        Route::get('/{missionId}/report', [SurveyController::class, 'report'])->name('read.report')->whereNumber('missionId');
        Route::get('/{missionId}/survey', [SurveyController::class, 'survey'])->name('read.survey')->whereNumber('missionId');

        //AJAX
        Route::post('/{missionId}/attend/try', [AttendController::class, 'try'])->name('read.attend.try');
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

