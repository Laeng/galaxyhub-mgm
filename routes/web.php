<?php

use App\Http\Controllers\Account\ViewAuthController;
use App\Http\Controllers\Join\ApiJoinController;
use App\Http\Controllers\Join\ViewJoinController;
use App\Http\Controllers\Staff\ApiManageUserApplicationController;
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


Route::middleware('web')->prefix('lounge')->group(function() {
    Route::get('/login', [ViewAuthController::class, 'login'])->name('account.auth.login');
    Route::get('/callback', [ViewAuthController::class, 'callback'])->name('account.auth.callback.steam');
    Route::get('/logout', [ViewAuthController::class, 'logout'])->name('account.auth.logout');
});

Route::middleware(['auth:web', CheckInactiveUser::class])->prefix('lounge')->group(function() {
    Route::get('/join/agree', [ViewJoinController::class, 'agree'])->name('join.agree');
    Route::post('/join/check/steam/status', [ApiJoinController::class, 'check_steam_status'])->name('join.check.steam.status');
    Route::any('/join/apply', [ViewJoinController::class, 'apply'])->name('join.apply');
    Route::post('/join/submit', [ViewJoinController::class, 'submit'])->name('join.submit');

    Route::get('/', [\App\Http\Controllers\Lounge\ViewLoungeController::class, 'index'])->name('lounge.index');
});

Route::middleware(['auth:web', \App\Http\Middleware\AllowOnlyStaff::class])->prefix('staff')->group(function() {
    Route::get('/user/all/list', [ViewManageUserController::class, 'list'])->name('staff.user.all.list');
    Route::get('/user/all/{id}', [ViewManageUserController::class, 'detail'])->name('staff.user.all.detail');
    Route::get('/user/application', [ViewManageUserApplicationController::class, 'list'])->name('staff.user.application');
    Route::post('/user/application/get', [ApiManageUserApplicationController::class, 'get'])->name('staff.user.application.get');
    Route::post('/user/application/process', [ApiManageUserApplicationController::class, 'process'])->name('staff.user.application.process');
    Route::get('/user/application/{id}', [ViewManageUserApplicationController::class, 'detail'])->name('staff.user.application.detail');
    Route::post('/user/application/{id}/info', [ApiManageUserApplicationController::class, 'detail_info'])->name('staff.user.application.detail.info');
    Route::get('/user/application/{id}/revision/{survey_id}', [ViewManageUserApplicationController::class, 'detailRevision'])->name('staff.user.application.detail.revision');
});

