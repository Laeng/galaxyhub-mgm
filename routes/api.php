<?php

use App\Http\Controllers\App\Updater\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::name('updater.')->prefix('updater')->group(function () {
        Route::post('/verify', [APIController::class, 'verify']);
        Route::post('/user/data', [APIController::class, 'getUserData']);
        Route::patch('/user/data', [APIController::class, 'setUserData']);
        Route::post('/server/data', [APIController::class, 'getServerData']);
        Route::post('/ping', [APIController::class, 'ping']);

        Route::get('/view/updater/{code}', [APIController::class, 'viewUpdaterIndex'])->whereUuid('code');
    });

});
