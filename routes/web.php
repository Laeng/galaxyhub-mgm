<?php

use App\Http\Controllers\Account\ViewAuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['auth:web', \App\Http\Middleware\CheckInactiveUser::class])->prefix('lounge')->group(function() {
    Route::get('/join', [\App\Http\Controllers\Join\ViewJoinController::class, 'apply'])->name('join.apply');
    Route::post('/join/submit', [\App\Http\Controllers\Join\ViewJoinController::class, 'applySubmit'])->name('join.apply.submit');

    Route::get('/', [\App\Http\Controllers\Lounge\ViewLoungeController::class, 'index'])->name('lounge.index');
});

Route::middleware(['auth:web', \App\Http\Middleware\AllowOnlyStaff::class])->prefix('/staff/lounge')->group(function() {

});

