<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('apartments', ApartmentController::class)->except(['edit', 'update', 'destroy']);

Route::get('/apartments/my', [ApartmentController::class, 'myApartments'])->name('apartments.my');

Route::post('/apartments/{apartment}/book', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('agents.show');
Route::get('/become-agent', [AgentController::class, 'becomeForm'])->name('agent.become.form');

Route::middleware(['auth'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('/agent/apartments', [AgentController::class, 'myApartments'])->name('agent.apartments');
    Route::get('/agent/bookings', [AgentController::class, 'manageBookings'])->name('agent.bookings');
    Route::patch('/agent/bookings/{booking}', [AgentController::class, 'updateBookingStatus'])->name('agent.bookings.update');
    Route::post('/become-agent', [AgentController::class, 'becomeAgent'])->name('agent.become');
    Route::get('/apartments/create', [ApartmentController::class, 'create'])->name('apartments.create');
});

require __DIR__.'/auth.php';