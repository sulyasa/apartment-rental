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
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                            <div class="relative h-48 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors duration-300"></div>
                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $apartment->title }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay group-hover:scale-110 transition-transform duration-700">
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-gray-800 shadow-sm">
                                    @if($apartment->type === 'flat') Квартира
                                    @elseif($apartment->type === 'house') Дом
                                    @elseif($apartment->type === 'studio') Студия
                                    @else Комната @endif
                                </span>
                            </div>
                            <div class="p-5 flex-grow flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-indigo-600 font-medium mb-2">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <span>{{ $apartment->city }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $apartment->title }}</h3>
                                <p class="text-gray-500 text-xs mb-4 line-clamp-1">{{ Str::limit($apartment->address, 30) }}</p>
                                
                                <div class="flex items-center justify-between mb-4 py-3 border-y border-gray-100">
                                    <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                        <i class="fas fa-door-open text-gray-400"></i>
                                        <span class="font-medium">{{ $apartment->rooms }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                        <i class="fas fa-vector-square text-gray-400"></i>
                                        <span class="font-medium">{{ $apartment->area }} м²</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                        <i class="fas fa-layer-group text-gray-400"></i>
                                        <span class="font-medium">{{ $apartment->floor }} эт.</span>
                                    </div>
                                </div>
                                
                                <div class="mt-auto flex justify-between items-end">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-0.5">В месяц</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-xl font-bold text-gray-900">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('apartments.show', $apartment) }}" class="flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                        <i class="fas fa-arrow-right"></i>
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