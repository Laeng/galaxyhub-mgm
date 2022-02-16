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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require_once __DIR__.'/web/application.php';
require_once __DIR__.'/web/auth.php';
require_once __DIR__.'/web/file.php';
require_once __DIR__.'/web/lounge.php';
