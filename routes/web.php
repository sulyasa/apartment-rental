<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/apartments', [ApartmentController::class, 'index'])->name('apartments.index');
Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show');

Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('agents.show');
Route::get('/api/cities', [ApartmentController::class, 'searchCities'])->name('api.cities');

Route::middleware(['auth'])->group(function () {
    Route::get('/apartments/my/list', [ApartmentController::class, 'myApartments'])->name('apartments.my');
    Route::get('/apartment/create', [ApartmentController::class, 'create'])->name('apartments.create');
    Route::post('/apartments', [ApartmentController::class, 'store'])->name('apartments.store');
    
    Route::get('/apartments/{apartment}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/apartments/{apartment}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/become-agent', [AgentController::class, 'becomeForm'])->name('agent.become.form');
    Route::post('/become-agent', [AgentController::class, 'becomeAgent'])->name('agent.become');
    
    Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('/agent/apartments', [AgentController::class, 'myApartments'])->name('agent.apartments');
    Route::get('/agent/bookings', [AgentController::class, 'manageBookings'])->name('agent.bookings');
    Route::patch('/agent/bookings/{booking}', [AgentController::class, 'updateBookingStatus'])->name('agent.bookings.update');
});

require __DIR__.'/auth.php';