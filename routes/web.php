<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestEntryController;
use App\Http\Controllers\PublicLandingController;
use App\Http\Controllers\PublicGuestController;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicLandingController::class)->name('landing');
Route::get('/guest/create', [PublicGuestController::class, 'create'])->name('guest.create');
Route::post('/guest', [PublicGuestController::class, 'store'])->name('guest.store');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'can:access-admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/guests', [GuestEntryController::class, 'index'])->name('guests.index');
        Route::get('/guests/{guestEntry}', [GuestEntryController::class, 'show'])->name('guests.show');
        Route::post('/guests/{guestEntry}/approve', [GuestEntryController::class, 'approve'])->name('guests.approve');
        Route::post('/guests/{guestEntry}/reject', [GuestEntryController::class, 'reject'])->name('guests.reject');
        Route::delete('/guests/{guestEntry}', [GuestEntryController::class, 'destroy'])->name('guests.destroy');
        Route::get('/guests/export/approved', [GuestEntryController::class, 'exportApproved'])->name('guests.export.approved');
        Route::get('/guests/export/rejected', [GuestEntryController::class, 'exportRejected'])->name('guests.export.rejected');
    });
