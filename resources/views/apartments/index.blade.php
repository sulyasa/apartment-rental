@extends('layouts.app')

@section('title', 'Квартиры - Аренда')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Доступные квартиры</h1>
        <p class="text-gray-600 mt-2">Найдите идеальное жильё из {{ $apartments->total() }} предложений</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg">Фильтры</h3>
                    <a href="{{ route('apartments.index') }}" class="text-sm text-indigo-600 hover:underline">Сбросить</a>
                </div>
                <form action="{{ route('apartments.index') }}" method="GET">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Город</label>
                        <input type="text" name="city" value="{{ request('city') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Введите город">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Тип жилья</label>
                        <select name="type" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Все типы</option>
                            <option value="flat" {{ request('type') == 'flat' ? 'selected' : '' }}>Квартира</option>
                            <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>Дом</option>
                            <option value="studio" {{ request('type') == 'studio' ? 'selected' : '' }}>Студия</option>
                            <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Комната</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Цена от (₽)</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="0">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Цена до (₽)</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="999999">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Комнаты</label>
                        <select name="rooms" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Любое количество</option>
                            <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1 комната</option>
                            <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2 комнаты</option>
                            <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3 комнаты</option>
                            <option value="4" {{ request('rooms') == '4' ? 'selected' : '' }}>4+ комнаты</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">
                        <i class="fas fa-filter"></i> Применить
                    </button>
                </form>
            </div>
        </div>
        
        <div class="lg:col-span-3">
            @if($apartments->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Квартиры не найдены. Попробуйте изменить параметры поиска.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($apartments as $apartment)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-building text-5xl text-white opacity-50"></i>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $apartment->title }}</h3>
                                    <span class="bg-indigo-100 text-indigo-600 px-2 py-1 rounded text-xs">{{ $apartment->type }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2"><i class="fas fa-map-marker-alt"></i> {{ $apartment->city }}, {{ Str::limit($apartment->address, 30) }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                    <span><i class="fas fa-bed"></i> {{ $apartment->rooms }}</span>
                                    <span><i class="fas fa-ruler-combined"></i> {{ $apartment->area }} м²</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                        <span class="text-gray-500 text-sm">/мес</span>
                                    </div>
                                    <a href="{{ route('apartments.show', $apartment) }}" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $apartments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection