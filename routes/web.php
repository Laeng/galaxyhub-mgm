<?php

use App\Http\Controllers\Lounge\Account\ApiAccountController;
use App\Http\Controllers\Lounge\Account\ViewAuthController;
use App\Http\Controllers\Lounge\Join\ApiJoinController;
use App\Http\Controllers\Lounge\Join\ViewJoinController;
use App\Http\Controllers\Lounge\Mission\ApiMissionController;
use App\Http\Controllers\Lounge\Mission\ViewMissionController;
use App\Http\Controllers\Lounge\ViewLoungeController;
use App\Http\Controllers\Staff\ApiManageUserApplicationController;
use App\Http\Controllers\Staff\ApiManageUserController;
use App\Http\Controllers\Staff\ApiManageUserMemo;
use App\Http\Controllers\Staff\ViewManageUserApplicationController;
use App\Http\Controllers\Staff\ViewManageUserController;
use App\Http\Middleware\CheckInactiveUser;
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
        Route::any( '/apply', [ViewJoinController::class, 'apply'])->name('apply');
        Route::post('/submit', [ViewJoinController::class, 'submit'])->name('submit');
    });
});

Route::middleware(['auth:web'])->prefix('lounge')->group(function () {
    Route::get('/', [ViewLoungeController::class, 'index'])->name('lounge.index');
});

Route::middleware(['auth:web', CheckInactiveUser::class])->prefix('lounge')->group(function() {
    Route::prefix('mission')->name('mission.')->group(function () {
        Route::get( '/', [ViewMissionController::class, 'list'])->name('list');
        Route::post( '/list', [ApiMissionController::class, 'list'])->name('api.list');
        Route::get( '/create', [ViewMissionController::class, 'create'])->name('create');
        Route::post( '/create/submit', [ApiMissionController::class, 'create'])->name('api.create');
        Route::get( '/{id}', [ViewMissionController::class, 'read'])->name('read');
        Route::get( '/{id}/update', [ViewMissionController::class, 'update'])->name('update');
        Route::get( '/{id}/delete', [ViewMissionController::class, 'delete'])->name('remove');
    });

});

Route::middleware(['auth:web', \App\Http\Middleware\AllowOnlyStaff::class])->prefix('staff')->name('staff.')->group(function() {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/all', [ViewManageUserController::class, 'list'])->name('all');
        Route::post( '/all/list', [ApiManageUserController::class, 'list'])->name('api.all.list');
        Route::get( '/all/{id}', [ViewManageUserController::class, 'read'])->name('all.read');

        Route::get( '/application', [ViewManageUserApplicationController::class, 'list'])->name('application');
        Route::post('/application/list', [ApiManageUserApplicationController::class, 'list'])->name('api.application.list');
        Route::post('/application/process', [ApiManageUserApplicationController::class, 'process'])->name('api.application.process');
        Route::get( '/application/{id}', [ViewManageUserApplicationController::class, 'read'])->name('application.read');
        Route::post('/application/{id}/info', [ApiManageUserApplicationController::class, 'detail_info'])->name('api.application.detail.info');
        Route::get('/application/{id}/games', [ViewManageUserApplicationController::class, 'detailOwnedGames'])->name('application.detail.games');

        Route::post('/memo/list', [ApiManageUserMemo::class, 'list'])->name('api.memo.list');
        Route::post('/memo/delete', [ApiManageUserMemo::class, 'delete'])->name('api.memo.delete');
        Route::post('/memo/create', [ApiManageUserMemo::class, 'create'])->name('api.memo.create');
    });

    Route::prefix('mission')->name('mission.')->group(function () {

    });
});

