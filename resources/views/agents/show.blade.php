@extends('layouts.app')

@section('title', $agent->user->name . ' - Агент')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center">
                <span class="text-6xl font-bold text-indigo-600">{{ substr($agent->user->name, 0, 1) }}</span>
            </div>
        </div>
        
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ $agent->user->name }}</h1>
                <div class="flex items-center justify-center mt-2 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($agent->rating) ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                    @endfor
                    <span class="ml-2 text-xl text-gray-600">({{ number_format($agent->rating, 1) }})</span>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ $agent->bio }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $agent->experience_years }}</p>
                    <p class="text-gray-600">Лет опыта</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $agent->total_bookings }}</p>
                    <p class="text-gray-600">Бронирований</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ number_format($agent->rating, 1) }}</p>
                    <p class="text-gray-600">Рейтинг</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $agent->commission_rate }}%</p>
                    <p class="text-gray-600">Комиссия</p>
                </div>
            </div>

            @if($agent->license_number)
                <div class="mb-6">
                    <p class="text-gray-600"><strong>Номер лицензии:</strong> {{ $agent->license_number }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-6">Квартиры агента</h2>
        @if($apartments->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">У агента пока нет квартир.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($apartments as $apartment)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-building text-5xl text-white opacity-50"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ $apartment->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $apartment->city }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                <a href="{{ route('apartments.show', $apartment) }}" class="text-indigo-600 hover:underline">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection