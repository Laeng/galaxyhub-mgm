<?php

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

require_once __DIR__ . '/web/user/account.php';
require_once __DIR__ . '/web/user/app.php';
require_once __DIR__ . '/web/user/application.php';
require_once __DIR__ . '/web/user/file.php';
require_once __DIR__ . '/web/user/mission.php';
require_once __DIR__ . '/web/user/updater.php';

require_once __DIR__ . '/web/admin/admin.php';
require_once __DIR__ . '/web/admin/application.php';
require_once __DIR__ . '/web/admin/broadcast.php';
require_once __DIR__ . '/web/admin/memo.php';
require_once __DIR__ . '/web/admin/statistic.php';
require_once __DIR__ . '/web/admin/updater.php';
require_once __DIR__ . '/web/admin/user.php';


Route::get('/', function () {
    return view('welcome');
})->name('welcome');
