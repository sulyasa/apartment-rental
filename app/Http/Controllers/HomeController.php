<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featured = Apartment::where('status', 'available')
            ->with('agent')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $cities = Apartment::where('status', 'available')
            ->distinct()
            ->pluck('city')
            ->take(8);

        return view('home', compact('featured', 'cities'));
    }
}