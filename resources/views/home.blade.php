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
                    <div class="md:col-span-2 relative" id="citySearchContainer">
                        <input type="text" name="city" id="cityInput" autocomplete="off" placeholder="Город или район" 
                            class="w-full px-4 py-3 bg-white/90 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <!-- Dropdown for autocomplete -->
                        <div id="cityDropdown" class="absolute z-50 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-100 hidden overflow-hidden">
                            <ul id="cityList" class="py-2 text-gray-700 text-sm">
                                <!-- Results injected via JS -->
                            </ul>
                        </div>
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
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                    <div class="relative h-64 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors duration-300"></div>
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $apartment->title }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay group-hover:scale-110 transition-transform duration-700">
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-semibold text-gray-800 shadow-sm">
                            @if($apartment->type === 'flat') Квартира
                            @elseif($apartment->type === 'house') Дом
                            @elseif($apartment->type === 'studio') Студия
                            @else Комната @endif
                        </span>
                        @if($apartment->agent)
                        <span class="absolute top-4 right-4 bg-indigo-600/90 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-semibold text-white shadow-sm flex items-center gap-1.5">
                            <i class="fas fa-shield-check"></i> Надежный агент
                        </span>
                        @endif
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex items-center gap-2 text-sm text-indigo-600 font-medium mb-3">
                            <i class="fas fa-map-marker-alt"></i> 
                            <span>{{ $apartment->city }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $apartment->title }}</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-1">{{ $apartment->address }}</p>
                        
                        <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-y border-gray-100">
                            <div class="flex flex-col items-center justify-center text-center">
                                <i class="fas fa-door-open text-gray-400 mb-1 text-lg"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $apartment->rooms }} ком.</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-center border-x border-gray-100">
                                <i class="fas fa-vector-square text-gray-400 mb-1 text-lg"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $apartment->area }} м²</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-center">
                                <i class="fas fa-layer-group text-gray-400 mb-1 text-lg"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $apartment->floor }} этаж</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto flex justify-between items-end pt-2">
                            <div>
                                <p class="text-sm text-gray-500 mb-0.5">Аренда в месяц</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                </div>
                            </div>
                            <a href="{{ route('apartments.show', $apartment) }}" class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <i class="fas fa-arrow-right"></i>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cityInput = document.getElementById('cityInput');
    const cityDropdown = document.getElementById('cityDropdown');
    const cityList = document.getElementById('cityList');
    let timeoutId;

    cityInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();
        
        if (query.length < 1) {
            cityDropdown.classList.add('hidden');
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`/api/cities?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    cityList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(city => {
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer transition-colors';
                            li.textContent = city;
                            li.addEventListener('mousedown', function() {
                                cityInput.value = city;
                                cityDropdown.classList.add('hidden');
                            });
                            cityList.appendChild(li);
                        });
                        cityDropdown.classList.remove('hidden');
                    } else {
                        cityDropdown.classList.add('hidden');
                    }
                })
                .catch(err => console.error(err));
        }, 300); // Debounce
    });

    cityInput.addEventListener('blur', function() {
        cityDropdown.classList.add('hidden');
    });

    cityInput.addEventListener('focus', function() {
        if (this.value.trim().length > 0 && cityList.children.length > 0) {
            cityDropdown.classList.remove('hidden');
        }
    });
});
</script>
@endsection