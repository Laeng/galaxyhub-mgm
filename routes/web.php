<?php

use App\Http\Controllers\Lounge\Account\ApiAccountController;
use App\Http\Controllers\Lounge\Account\ViewAuthController;
use App\Http\Controllers\Lounge\Join\ApiJoinController;
use App\Http\Controllers\Lounge\Join\ViewJoinController;
use App\Http\Controllers\Lounge\Mission\ApiMissionController;
use App\Http\Controllers\Lounge\Mission\ViewMissionController;
use App\Http\Controllers\Lounge\ViewLoungeController;
use App\Http\Controllers\Staff\User\All\ApiUserAllController;
use App\Http\Controllers\Staff\User\All\ViewUserAllController;
use App\Http\Controllers\Staff\User\Application\ApiUserApplicationController;
use App\Http\Controllers\Staff\User\Application\ViewUserApplicationController;
use App\Http\Controllers\Staff\User\Memo\ApiUserMemo;
use App\Http\Middleware\ForbidBannedUser;
use App\Http\Middleware\ForbidUser;
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
    Route::get( '/login', [ViewAuthController::class, 'login'])->name('account.auth.login');
    Route::get( '/callback', [ViewAuthController::class, 'callback'])->name('account.auth.callback.steam');
    Route::get( '/logout', [ViewAuthController::class, 'logout'])->name('account.auth.logout');
});

Route::middleware(['auth:web'])->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
        Route::post('/leave', [ApiAccountController::class, 'leave'])->name('leave');
    });

    Route::prefix('join')->name('join.')->group(function () {
        Route::get( '/agree', [ViewJoinController::class, 'agree'])->name('agree');
        Route::post('/check/steam/status', [ApiJoinController::class, 'check_steam_status'])->name('check.steam.status');
        Route::match(['get', 'post'], '/apply', [ViewJoinController::class, 'apply'])->name('apply');
        Route::post('/submit', [ViewJoinController::class, 'submit'])->name('submit');
    });
});

Route::middleware(['auth:web'])->prefix('lounge')->name('lounge.')->group(function () {
    Route::get('/', [ViewLoungeController::class, 'index'])->name('index');
});

Route::middleware(['auth:web', ForbidBannedUser::class])->prefix('lounge')->name('lounge.')->group(function() {

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

    });
    Route::prefix('missions')->name('mission.')->group(function () {
        Route::get( '/', [ViewMissionController::class, 'list'])->name('list');
        Route::post( '/list', [ApiMissionController::class, 'list'])->name('list.api');
    });

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

