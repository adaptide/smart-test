<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/tickets', [TicketController::class, 'store']);
});

// Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
//     Route::get('/tickets/statistics', [StatisticsController::class, 'index'])->name('api.statistics.index');
//     Route::get('/tickets/statistics/all', [StatisticsController::class, 'all'])->name('api.statistics.all');
// });
