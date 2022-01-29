<?php

use App\Http\Controllers\Software\ApiSoftwareController;
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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// https://mgm.galaxyhub.kr/api/v1/
Route::prefix('v1')->group(function () {
    Route::prefix('software')->name('software.')->group(function () {
        // USER
        Route::prefix('user')->name('user.')->group(function () {
            Route::post('data', [ApiSoftwareController::class, 'getUserData']);
            Route::patch('data', [ApiSoftwareController::class, 'setUserData']);
        });


        Route::post('verify', [ApiSoftwareController::class, 'verify']);

    });
});
