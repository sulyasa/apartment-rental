<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'notes' => 'nullable|string|max:500',
        ]);

        $nights = $validated['check_in']->diffInDays($validated['check_out']);
        $totalPrice = $apartment->price * $nights;

        Booking::create([
            'apartment_id' => $apartment->id,
            'user_id' => Auth::id(),
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('bookings.my')
            ->with('success', 'Бронирование создано! Ожидайте подтверждения.');
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('apartment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.my', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Невозможно отменить это бронирование.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Бронирование отменено.');
    }
}