<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkInDate = \Carbon\Carbon::parse($validated['check_in']);
        $checkOutDate = \Carbon\Carbon::parse($validated['check_out']);
        $nights = $checkInDate->diffInDays($checkOutDate);
        $totalPrice = $apartment->price * $nights;

        return view('bookings.checkout', compact('apartment', 'checkInDate', 'checkOutDate', 'nights', 'totalPrice'));
    }

    public function store(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|string',
        ]);

        $checkInDate = \Carbon\Carbon::parse($validated['check_in']);
        $checkOutDate = \Carbon\Carbon::parse($validated['check_out']);
        $nights = $checkInDate->diffInDays($checkOutDate);
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
            ->with('success', 'Бронирование успешно оплачено и создано! Ожидайте подтверждения от владельца.');
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