<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::query()->with('agent');

        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('rooms') && $request->rooms) {
            $query->where('rooms', $request->rooms);
        }

        $apartments = $query->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('apartments.index', compact('apartments'));
    }

    public function show(Apartment $apartment)
    {
        $apartment->load(['agent', 'owner']);
        return view('apartments.show', compact('apartment'));
    }

    public function create()
    {
        return view('apartments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'rooms' => 'required|integer|min:1',
            'floor' => 'nullable|integer|min:1',
            'total_floors' => 'nullable|integer|min:1',
            'area' => 'required|integer|min:10',
            'type' => 'required|in:flat,house,room,studio',
            'amenities' => 'nullable|array',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $validated['user_id'] = auth()->id();
        if (auth()->user() && auth()->user()->isAgent()) {
            $validated['agent_id'] = auth()->id();
        }
        $validated['status'] = 'available';
        $validated['amenities'] = json_encode($validated['amenities'] ?? []);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('apartments', 'public');
        }

        Apartment::create($validated);

        return redirect()->route('apartments.index')
            ->with('success', 'Квартира успешно добавлена!');
    }

    public function myApartments()
    {
        $apartments = Apartment::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('apartments.my', compact('apartments'));
    }

    public function searchCities(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }

        $cities = Apartment::where('city', 'like', "%{$query}%")
            ->where('status', 'available')
            ->distinct()
            ->limit(5)
            ->pluck('city');

        return response()->json($cities);
    }
}