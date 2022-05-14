<?php

use App\Http\Controllers\App\Admin\Budget\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::prefix('budget')->name('budget.')->middleware(['auth.admin:web'])->group(function() {
            //VIEW
            Route::get('/live', [BudgetController::class, 'live'])->name('live');

            //AJAX
            Route::post('/live/azure', [BudgetController::class, 'getAzureDetail'])->name('live.azure');
        });


    });
});
