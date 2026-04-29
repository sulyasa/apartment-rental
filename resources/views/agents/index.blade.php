@extends('layouts.app')

@section('title', 'Агенты')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Наши агенты</h1>
    
    @if($agents->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Агенты пока не зарегистрированы.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($agents as $agent)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                            <span class="text-4xl font-bold text-indigo-600">{{ substr($agent->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800">{{ $agent->user->name }}</h3>
                        <div class="flex items-center justify-center mt-2 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($agent->rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-gray-600">({{ number_format($agent->rating, 1) }})</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($agent->bio, 100) }}</p>
                        <div class="flex justify-center space-x-4 text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-building"></i> {{ $agent->experience_years }} лет</span>
                            <span><i class="fas fa-calendar-check"></i> {{ $agent->total_bookings }} брон.</span>
                        </div>
                        <a href="{{ route('agents.show', $agent) }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                            Профиль
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $agents->links() }}
        </div>
    @endif
</div>
@endsection