@extends('layouts.app')

@section('title', $apartment->title . ' - Аренда')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="h-80 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
            <i class="fas fa-building text-8xl text-white opacity-50"></i>
        </div>
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $apartment->title }}</h1>
                    <p class="text-gray-600 mt-2"><i class="fas fa-map-marker-alt"></i> {{ $apartment->city }}, {{ $apartment->address }}</p>
                </div>
                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-lg text-lg font-semibold">
                    {{ $apartment->status === 'available' ? 'Доступно' : 'Арендовано' }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-600 mb-2">Параметры</h3>
                    <div class="space-y-2">
                        <p><i class="fas fa-bed text-indigo-600 w-8"></i> <strong>Комнат:</strong> {{ $apartment->rooms }}</p>
                        <p><i class="fas fa-ruler-combined text-indigo-600 w-8"></i> <strong>Площадь:</strong> {{ $apartment->area }} м²</p>
                        <p><i class="fas fa-layer-group text-indigo-600 w-8"></i> <strong>Этаж:</strong> {{ $apartment->floor ?? 'Не указан' }} / {{ $apartment->total_floors ?? 'Не указан' }}</p>
                        <p><i class="fas fa-home text-indigo-600 w-8"></i> <strong>Тип:</strong> {{ $apartment->type }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-600 mb-2">Цена</h3>
                    <p class="text-4xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</p>
                    <p class="text-gray-500">в месяц</p>
                </div>
                
                @if($apartment->agent)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-600 mb-2">Агент</h3>
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-xl font-bold">{{ substr($apartment->agent->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $apartment->agent->name }}</p>
                            <a href="{{ route('agents.show', $apartment->agent) }}" class="text-indigo-600 text-sm">Профиль агента</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="mb-8">
                <h3 class="font-semibold text-xl mb-4">Описание</h3>
                <p class="text-gray-700 leading-relaxed">{{ $apartment->description }}</p>
            </div>

            @if($apartment->amenities)
            <div class="mb-8">
                <h3 class="font-semibold text-xl mb-4">Удобства</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach(json_decode($apartment->amenities, true) ?? [] as $amenity)
                        <span class="bg-gray-100 px-4 py-2 rounded-lg">
                            <i class="fas fa-check text-green-500 mr-2"></i>{{ $amenity }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            @auth
                @if($apartment->status === 'available')
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-xl mb-4">Забронировать</h3>
                    <form action="{{ route('bookings.store', $apartment) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium mb-2">Дата заезда</label>
                            <input type="date" name="check_in" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Дата выезда</label>
                            <input type="date" name="check_out" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                                Забронировать
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            @else
                <div class="bg-yellow-50 p-6 rounded-lg">
                    <p class="text-yellow-800">
                        <a href="{{ route('login') }}" class="font-semibold underline">Войдите</a> чтобы забронировать эту квартиру.
                    </p>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection