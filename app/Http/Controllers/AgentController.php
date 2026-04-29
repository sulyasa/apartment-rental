<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::where('status', 'active')
            ->with('user')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('agents.index', compact('agents'));
    }

    public function show(Agent $agent)
    {
        $agent->load('user');
        
        $apartments = Apartment::where('agent_id', $agent->user_id)
            ->where('status', 'available')
            ->paginate(6);

        return view('agents.show', compact('agent', 'apartments'));
    }

    public function becomeForm()
    {
        return view('agents.become');
    }

    public function dashboard()
    {
        $agent = Agent::where('user_id', auth()->id())->firstOrFail();
        
        $stats = [
            'total_apartments' => Apartment::where('agent_id', auth()->id())->count(),
            'active_bookings' => Booking::whereHas('apartment', function ($q) {
                $q->where('agent_id', auth()->id());
            })->whereIn('status', ['pending', 'confirmed'])->count(),
            'total_earnings' => Booking::whereHas('apartment', function ($q) {
                $q->where('agent_id', auth()->id());
            })->where('status', 'completed')->sum('total_price'),
            'rating' => $agent->rating,
        ];

        $recentBookings = Booking::whereHas('apartment', function ($q) {
            $q->where('agent_id', auth()->id());
        })->with('apartment', 'user')->latest()->take(5)->get();

        return view('agents.dashboard', compact('agent', 'stats', 'recentBookings'));
    }

    public function myApartments()
    {
        $apartments = Apartment::where('agent_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('agents.apartments', compact('apartments'));
    }

    public function manageBookings()
    {
        $bookings = Booking::whereHas('apartment', function ($q) {
            $q->where('agent_id', auth()->id());
        })->with('apartment', 'user')->latest()->paginate(10);

        return view('agents.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Booking $booking, Request $request)
    {
        if ($booking->apartment->agent_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Статус бронирования обновлён.');
    }

    public function becomeAgent(Request $request)
    {
        $request->validate([
            'license_number' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        
        if ($user->role !== 'user') {
            return back()->with('error', 'Вы уже являетесь агентом.');
        }

        Agent::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years ?? 0,
            'status' => 'active',
        ]);

        $user->update(['role' => 'agent']);

        return redirect()->route('agent.dashboard')
            ->with('success', 'Поздравляем! Теперь вы агент.');
    }
}