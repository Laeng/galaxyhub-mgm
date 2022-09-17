<?php

use App\Http\Controllers\App\Mission\ApiController as MissionAPIController;
use App\Http\Controllers\App\Updater\APIController as UpdaterAPIController;
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
        Route::post('/verify', [UpdaterAPIController::class, 'verify']);
        Route::post('/user/data', [UpdaterAPIController::class, 'getUserData']);
        Route::patch('/user/data', [UpdaterAPIController::class, 'setUserData']);
        Route::post('/server/data', [UpdaterAPIController::class, 'getServerData']);
        Route::post('/ping', [UpdaterAPIController::class, 'ping']);

        Route::get('/view/updater/{code}', [UpdaterAPIController::class, 'viewUpdaterIndex'])->whereUuid('code');
    });

    Route::name('mission.')->prefix('mission')->group(function () {
        Route::name('server.')->prefix('server')->group(function () {
            Route::get('/deallocate', [MissionAPIController::class, 'deallocate']);
        });
    });

});
