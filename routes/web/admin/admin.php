<?php

use App\Http\Controllers\App\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->middleware(['auth.admin:web'])->group(function() {
        //VIEW
        Route::get('/', [AdminController::class, 'index'])->name('index');

        //AJAX

    });
});
