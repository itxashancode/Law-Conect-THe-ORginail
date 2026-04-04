<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLawyerController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminSlotController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Lawyer\LawyerDashboardController;
use App\Http\Controllers\Lawyer\LawyerProfileController;
use App\Http\Controllers\Lawyer\LawyerSlotController;
use App\Http\Controllers\Lawyer\LawyerAppointmentController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerSearchController;
use App\Http\Controllers\Customer\CustomerAppointmentController;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/search', [PublicController::class, 'search'])->name('public.search');

// Auth routes must come before /lawyer/{id} to avoid conflicts
require __DIR__.'/auth.php';

Route::get('/lawyer/{id}', [PublicController::class, 'lawyerProfile'])->name('public.lawyer');

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->hasRole('lawyer')) {
        return redirect()->route('lawyer.dashboard');
    }
    if (auth()->user()->hasRole('customer')) {
        return redirect()->route('customer.dashboard');
    }

    // Fallback: user has no role
    return view('errors.no-role');
})->middleware('auth')->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/',                           [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/lawyers',                    [AdminLawyerController::class, 'index'])->name('lawyers.index');
    Route::post('/lawyers/{id}/approve',      [AdminLawyerController::class, 'approve'])->name('lawyers.approve');
    Route::post('/lawyers/{id}/reject',       [AdminLawyerController::class, 'reject'])->name('lawyers.reject');
    Route::delete('/lawyers/{id}',            [AdminLawyerController::class, 'destroy'])->name('lawyers.destroy');
    Route::get('/bookings',                   [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/slots',                      [AdminSlotController::class, 'index'])->name('slots.index');
    Route::delete('/slots/{id}',              [AdminSlotController::class, 'destroy'])->name('slots.destroy');
    Route::get('/homepage',                   [AdminHomepageController::class, 'index'])->name('homepage.index');
    Route::post('/homepage',                  [AdminHomepageController::class, 'store'])->name('homepage.store');
    Route::put('/homepage/{id}',              [AdminHomepageController::class, 'update'])->name('homepage.update');
});

Route::prefix('lawyer')->name('lawyer.')->middleware(['auth', 'role.lawyer'])->group(function () {
    Route::get('/',                   [LawyerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',            [LawyerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',            [LawyerProfileController::class, 'update'])->name('profile.update');
    Route::get('/slots',              [LawyerSlotController::class, 'index'])->name('slots.index');
    Route::post('/slots',             [LawyerSlotController::class, 'store'])->name('slots.store');
    Route::delete('/slots/{id}',      [LawyerSlotController::class, 'destroy'])->name('slots.destroy');
    Route::get('/appointments',       [LawyerAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{id}',  [LawyerAppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{id}/confirm', [LawyerAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [LawyerAppointmentController::class, 'cancel'])->name('appointments.cancel');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role.customer'])->group(function () {
    Route::get('/',                               [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/search',                         [CustomerSearchController::class, 'index'])->name('search');
    Route::get('/appointments',                   [CustomerAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/book/{lawyerId}',   [CustomerAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',                  [CustomerAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}',              [CustomerAppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('/appointments/{id}',           [CustomerAppointmentController::class, 'destroy'])->name('appointments.cancel');
});
