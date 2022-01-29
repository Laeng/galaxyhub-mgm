<?php

use App\Http\Controllers\Lounge\Account\ApiAccountController;
use App\Http\Controllers\Lounge\Account\ViewAccountController;
use App\Http\Controllers\Lounge\Account\ViewAuthController;
use App\Http\Controllers\Lounge\Application\ApiApplicationController;
use App\Http\Controllers\Lounge\Application\ViewApplicationController;
use App\Http\Controllers\Lounge\File\ApiFileController;
use App\Http\Controllers\Lounge\Mission\ApiMissionController;
use App\Http\Controllers\Lounge\Mission\ViewMissionController;
use App\Http\Controllers\Lounge\ViewLoungeController;
use App\Http\Controllers\Software\ViewSoftwareController;
use App\Http\Controllers\Staff\User\All\ApiUserAllController;
use App\Http\Controllers\Staff\User\All\ViewUserAllController;
use App\Http\Controllers\Staff\User\Application\ApiUserApplicationController;
use App\Http\Controllers\Staff\User\Application\ViewUserApplicationController;
use App\Http\Controllers\Staff\User\Memo\ApiUserMemo;
use App\Http\Middleware\ForbidApplicant;
use App\Http\Middleware\ForbidBannedUser;
use App\Http\Middleware\ForbidUser;
use App\Http\Middleware\OnlyApplicant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware('web')->group(function() {
    // Auth
    Route::get( '/login', [ViewAuthController::class, 'login'])->name('account.auth.login');
    Route::get( '/callback', [ViewAuthController::class, 'callback'])->name('account.auth.callback.steam');
    Route::get( '/logout', [ViewAuthController::class, 'logout'])->name('account.auth.logout');
});

Route::middleware(['auth:web'])->group(function () {
    // ACCOUNT
    Route::prefix('account')->name('account.')->group(function () {
        Route::post('/leave', [ApiAccountController::class, 'leave'])->name('leave');
        Route::get('/suspended', [ViewAccountController::class, 'suspended'])->name('suspended');
    });

    // FILE
    Route::prefix('file')->name('file.')->group(function () {
        Route::prefix('upload')->name('upload.')->group(function () {
            Route::post('/filepond', [ApiFileController::class, 'filepond_upload'])->name('filepond.api');
            Route::post('/ckeditor', [ApiFileController::class, 'ckeditor_upload'])->name('ckeditor.api');
        });

        Route::prefix('delete')->name('delete.')->group(function () {
            Route::post('/filepond', [ApiFileController::class, 'filepond_delete'])->name('filepond.api');
        });

    });
});

Route::middleware(['auth:web', OnlyApplicant::class])->group(function () {
    // APPLICATION
    Route::prefix('application')->name('application.')->group(function () {
        Route::get( '/', [ViewApplicationController::class, 'index'])->name('index');
        Route::get( '/applied', [ViewApplicationController::class, 'apply'])->name('apply');
        Route::get( '/deferred', [ViewApplicationController::class, 'defer'])->name('defer');
        Route::get( '/rejected', [ViewApplicationController::class, 'reject'])->name('reject');

        // 퀴즈 불합격자에게 정보를 제공하기 위해 따로 빼둠.
        Route::get( '/agreements', [ViewApplicationController::class, 'agreements'])->name('agreements');
        Route::match(['get', 'post'], '/score', [ViewApplicationController::class, 'score'])->name('score');
    });

});

Route::middleware(['auth:web', ForbidBannedUser::class, OnlyApplicant::class])->group(function () {
    // APPLICATION
    Route::prefix('application')->name('application.')->group(function () {
        // Route::get( '/agreements', [ViewApplicationController::class, 'agreements'])->name('agreements');
        Route::post('/validate/steam', [ApiApplicationController::class, 'steam_validate'])->name('validate.steam.api');
        Route::match(['get', 'post'], '/quiz', [ViewApplicationController::class, 'quiz'])->name('quiz');
        // Route::match(['get', 'post'], '/score', [ViewApplicationController::class, 'score'])->name('score');
        Route::match(['get', 'post'], '/form', [ViewApplicationController::class, 'form'])->name('form');
        Route::post('/submit', [ViewApplicationController::class, 'submit'])->name('submit');
    });

});

Route::middleware(['auth:web', ForbidBannedUser::class, ForbidApplicant::class])->group(function() {

    // LOUNGE
    Route::prefix('lounge')->name('lounge.')->group(function () {

        Route::get('/', [ViewLoungeController::class, 'index'])->name('index');

        // MISSION
        Route::prefix('mission')->name('mission.')->group(function () {
            Route::redirect('/', '/lounge/missions');
            Route::get( '/new', [ViewMissionController::class, 'create'])->name('create');
            Route::post( '/create', [ApiMissionController::class, 'create'])->name('create.api');
            Route::get( '/{id}', [ViewMissionController::class, 'read'])->name('read')->whereNumber('id');
            Route::get('/{id}/edit', [ViewMissionController::class, 'update'])->name('update')->whereNumber('id');
            Route::post( '/{id}/update', [ApiMissionController::class, 'update'])->name('update.api')->whereNumber('id');
            Route::post( '/{id}/delete', [ApiMissionController::class, 'delete'])->name('delete.api')->whereNumber('id');
            Route::post( '/{id}/process', [ApiMissionController::class, 'read_process'])->name('read.process.api')->whereNumber('id');
            Route::post( '/{id}/refresh', [ApiMissionController::class, 'read_refresh'])->name('read.refresh.api')->whereNumber('id');
            Route::post( '/{id}/participants', [ApiMissionController::class, 'read_participants'])->name('read.participants.api')->whereNumber('id');
            Route::get( '/{id}/survey', [ViewMissionController::class, 'survey'])->name('survey')->whereNumber('id');
            Route::match(['get', 'post'], '/{id}/attend', [ViewMissionController::class, 'attend'])->name('attend')->whereNumber('id');
            Route::post( '/{id}/attend/process', [ApiMissionController::class, 'attend'])->name('attend.process.api')->whereNumber('id');
            Route::get( '/{id}/report', [ViewMissionController::class, 'report'])->name('report')->whereNumber('id');

        });
        Route::prefix('missions')->name('mission.')->group(function () {
            Route::get( '/', [ViewMissionController::class, 'list'])->name('list');
            Route::post( '/list', [ApiMissionController::class, 'list'])->name('list.api');
        });

    });


    Route::get('/authorize/{code}', [ViewSoftwareController::class, 'authorize_code'])->name('authorize')->whereUuid('code');

});


////// STAFF //////
Route::middleware(['auth:web', ForbidUser::class])->prefix('staff')->name('staff.')->group(function() {

    // USER
    Route::prefix('user')->name('user.')->group(function () {
        Route::redirect('/', '/staff/users');

        // APPLICATION
        Route::prefix('application')->name('application.')->group(function () {
            Route::redirect('/', '/staff/user/applications');
        });
        Route::prefix('applications')->name('application.')->group(function () {
            Route::get( '/', [ViewUserApplicationController::class, 'list'])->name('list');
            Route::post('/list', [ApiUserApplicationController::class, 'list'])->name('list.api');
            Route::post('/process', [ApiUserApplicationController::class, 'process'])->name('process.api');

            Route::get( '/{id}', [ViewUserApplicationController::class, 'read'])->name('read')->whereNumber('id');
            Route::post('/{id}/info', [ApiUserApplicationController::class, 'read_info'])->name('read.info.api')->whereNumber('id');
            Route::get('/{id}/games', [ViewUserApplicationController::class, 'read_games'])->name('read.games')->whereNumber('id');
        });

        // MEMO
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::post('/list', [ApiUserMemo::class, 'list'])->name('list.api');
            Route::post('/delete', [ApiUserMemo::class, 'delete'])->name('delete.api');
            Route::post('/create', [ApiUserMemo::class, 'create'])->name('create.api');
        });

        // USER
        Route::get( '/{id}', [ViewUserAllController::class, 'read'])->name('read')->whereNumber('id');
    });
    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', [ViewUserAllController::class, 'list'])->name('list');
        Route::post( '/list', [ApiUserAllController::class, 'list'])->name('list.api');
        Route::post('/process', [ApiUserAllController::class, 'process'])->name('process.api');
    });

    // MISSION
    Route::prefix('mission')->name('mission.')->group(function () {

    });
////
});

