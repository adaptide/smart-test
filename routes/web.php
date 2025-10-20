<?php

use App\Enums\User\Role;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/widget', [WidgetController::class, 'index'])->name('widget.index');

Route::middleware(['auth', 'role:'. Role::manager()->value])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
    Route::post('/tickets/{ticket}/response', [TicketController::class, 'addResponse'])->name('tickets.add-response');
});

include __DIR__ . '/auth.php';