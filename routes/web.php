<?php

use App\Http\Controllers\Account\ViewAuthController;
use App\Http\Controllers\Join\ApiJoinController;
use App\Http\Controllers\Join\ViewJoinController;
use App\Http\Controllers\Staff\ApiManageUserController;
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
    Route::post('/join/check/steam/status', [ApiJoinController::class, 'checkSteamStatus'])->name('join.check.steam.status');
    Route::any('/join/apply', [ViewJoinController::class, 'apply'])->name('join.apply');
    Route::post('/join/submit', [ViewJoinController::class, 'submit'])->name('join.submit');

    Route::get('/', [\App\Http\Controllers\Lounge\ViewLoungeController::class, 'index'])->name('lounge.index');
});

Route::middleware(['auth:web', \App\Http\Middleware\AllowOnlyStaff::class])->prefix('staff')->group(function() {
    Route::get('/user/list', [ViewManageUserController::class, 'list'])->name('staff.user.list');
    Route::get('/user/{user_id}', [ViewManageUserController::class, 'detail'])->name('staff.user.detail');
    Route::get('/user/applicant/list', [ViewManageUserController::class, 'applicantList'])->name('staff.user.applicant.list');
    Route::any('/user/applicant/list/get', [ApiManageUserController::class, 'getApplicantList'])->name('staff.user.applicant.list.get');
    Route::get('/user/applicant/{user_id}', [ViewManageUserController::class, 'applicantDetail'])->name('staff.user.applicant.detail');
});

