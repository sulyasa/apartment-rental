@extends('layouts.app')

@section('title', 'Главная - Аренда квартир')

@section('content')
{{-- Hero Section --}}
<div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-800 text-white">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-24">
        <div class="text-center">
            <span class="inline-block px-4 py-1 bg-white/10 rounded-full text-sm mb-6 backdrop-blur-sm">
                🏠 Найдите идеальное жильё
            </span>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Аренда квартир<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">без посредников</span>
            </h1>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                Более 1000 проверенных квартир от собственников и агентов. 
                Бронируйте онлайн без комиссии.
            </p>
            
            <form action="{{ route('apartments.index') }}" method="GET" class="max-w-5xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="city" placeholder="Город или район" 
                            class="w-full px-4 py-3 bg-white/90 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <select name="type" class="w-full px-4 py-3 bg-white/90 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Тип жилья</option>
                            <option value="flat">Квартира</option>
                            <option value="house">Дом</option>
                            <option value="studio">Студия</option>
                            <option value="room">Комната</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="min_price" placeholder="Цена от" 
                            class="w-full px-4 py-3 bg-white/90 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <input type="number" name="max_price" placeholder="Цена до" 
                            class="w-full px-4 py-3 bg-white/90 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all">
                            <i class="fas fa-search"></i> Найти
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="flex justify-center gap-8 mt-10 text-gray-400">
                <div class="text-center">
                    <p class="text-3xl font-bold text-white">1000+</p>
                    <p class="text-sm">Квартир</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-white">500+</p>
                    <p class="text-sm">Агентов</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-white">98%</p>
                    <p class="text-sm">Довольных клиентов</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Popular Cities --}}
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Популярные города</h2>
            <p class="text-gray-600 mt-2">Выберите город для поиска жилья</p>
        </div>
        <a href="{{ route('apartments.index') }}" class="text-indigo-600 hover:underline">Все квартиры →</a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($cities as $city)
            <a href="{{ route('apartments.index', ['city' => $city]) }}" 
               class="group bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-city text-white text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800">{{ $city }}</h3>
                <p class="text-sm text-gray-500">{{ App\Models\Apartment::where('city', $city)->where('status', 'available')->count() }} квартир</p>
            </a>
        @endforeach
    </div>
</div>

{{-- Featured Apartments --}}
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Рекомендуемые квартиры</h2>
            <p class="text-gray-600 mt-2">Лучшие предложения этого месяца</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featured as $apartment)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                    <div class="relative h-56 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
                        <i class="fas fa-building text-7xl text-white/30"></i>
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                            {{ $apartment->type }}
                        </span>
                        @if($apartment->agent)
                        <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-indigo-600">
                            <i class="fas fa-check-circle"></i> Верифицировано
                        </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition">{{ $apartment->title }}</h3>
                        <p class="text-gray-600 mb-3 flex items-center">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i> 
                            {{ $apartment->city }}, {{ Str::limit($apartment->address, 25) }}
                        </p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                            <span class="flex items-center"><i class="fas fa-bed mr-1"></i> {{ $apartment->rooms }} ком.</span>
                            <span class="flex items-center"><i class="fas fa-ruler-combined mr-1"></i> {{ $apartment->area }} м²</span>
                            <span class="flex items-center"><i class="fas fa-layer-group mr-1"></i> эт. {{ $apartment->floor }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t">
                            <div>
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                <span class="text-gray-500 text-sm">/мес</span>
                            </div>
                            <a href="{{ route('apartments.show', $apartment) }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('apartments.index') }}" class="inline-flex items-center bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition">
                Смотреть все квартиры 
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

{{-- Why Choose Us --}}
<div class="max-w-7xl mx-auto px-4 py-20">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-800">Почему выбирают нас</h2>
        <p class="text-gray-600 mt-2">Мы делаем поиск жилья простым и безопасным</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="text-center group">
            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fas fa-shield-alt text-3xl text-white"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Безопасность</h3>
            <p class="text-gray-600 text-sm">Все квартиры проходят проверку</p>
        </div>
        <div class="text-center group">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fas fa-clock text-3xl text-white"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Быстрый поиск</h3>
            <p class="text-gray-600 text-sm">Удобные фильтры и сортировка</p>
        </div>
        <div class="text-center group">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fas fa-headset text-3xl text-white"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Поддержка 24/7</h3>
            <p class="text-gray-600 text-sm">Поможем в любое время</p>
        </div>
        <div class="text-center group">
            <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fas fa-percent text-3xl text-white"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Лучшие цены</h3>
            <p class="text-gray-600 text-sm">Гарантия низких цен</p>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Готовы найти идеальную квартиру?</h2>
        <p class="text-xl mb-8 opacity-90">Присоединяйтесь к тысячам довольных арендаторов</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('apartments.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Начать поиск
            </a>
            <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition">
                Регистрация
            </a>
        </div>
    </div>
</div>
@endsection
                <input type="number" name="min_price" placeholder="Цена от" class="w-full px-4 py-3 border rounded-lg text-gray-800">
                <input type="number" name="max_price" placeholder="Цена до" class="w-full px-4 py-3 border rounded-lg text-gray-800">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                    <i class="fas fa-search"></i> Поиск
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Популярные города</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($cities as $city)
            <a href="{{ route('apartments.index', ['city' => $city]) }}" 
               class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition text-center">
                <i class="fas fa-city text-3xl text-indigo-600 mb-2"></i>
                <p class="font-semibold text-gray-800">{{ $city }}</p>
            </a>
        @endforeach
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Рекомендуемые квартиры</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($featured as $apartment)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-building text-6xl text-white opacity-50"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">{{ $apartment->title }}</h3>
                        <span class="bg-indigo-100 text-indigo-600 px-2 py-1 rounded text-sm">{{ $apartment->type }}</span>
                    </div>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt"></i> {{ $apartment->city }}, {{ $apartment->address }}</p>
                    <div class="flex items-center space-x-4 text-gray-600 mb-4">
                        <span><i class="fas fa-bed"></i> {{ $apartment->rooms }} ком.</span>
                        <span><i class="fas fa-ruler-combined"></i> {{ $apartment->area }} м²</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                            <span class="text-gray-500">/мес</span>
                        </div>
                        <a href="{{ route('apartments.show', $apartment) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Подробнее
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('apartments.index') }}" class="inline-block bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900">
            Смотреть все квартиры
        </a>
    </div>
</div>

<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Почему выбирают нас</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-shield-alt text-3xl text-indigo-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Безопасность</h3>
                <p class="text-gray-600">Все квартиры проверены</p>
            </div>
            <div class="text-center">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-clock text-3xl text-indigo-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Быстрый поиск</h3>
                <p class="text-gray-600">Удобные фильтры</p>
            </div>
            <div class="text-center">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-headset text-3xl text-indigo-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Поддержка</h3>
                <p class="text-gray-600">Помощь 24/7</p>
            </div>
            <div class="text-center">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-ruble-sign text-3xl text-indigo-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Лучшие цены</h3>
                <p class="text-gray-600">Гарантия низкой цены</p>
            </div>
        </div>
    </div>
</div>
@endsection