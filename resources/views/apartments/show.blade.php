@extends('layouts.app')

@section('title', $apartment->title . ' - Аренда')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="relative h-96 bg-gray-200 flex items-center justify-center overflow-hidden">
            @if($apartment->image)
                <img src="{{ Storage::url($apartment->image) }}" alt="{{ $apartment->title }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Placeholder" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <span class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-semibold text-gray-800 shadow-md">
                @if($apartment->type === 'flat') Квартира
                @elseif($apartment->type === 'house') Дом
                @elseif($apartment->type === 'studio') Студия
                @else Комната @endif
            </span>
        </div>
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $apartment->title }}</h1>
                    <p class="text-gray-600 mt-2 flex items-center gap-2"><i class="fas fa-map-marker-alt text-indigo-500"></i> {{ $apartment->city }}, {{ $apartment->address }}</p>
                </div>
                <span class="bg-{{ $apartment->status === 'available' ? 'green' : 'red' }}-100 text-{{ $apartment->status === 'available' ? 'green' : 'red' }}-700 px-4 py-2 rounded-xl text-sm font-semibold border border-{{ $apartment->status === 'available' ? 'green' : 'red' }}-200 shadow-sm">
                    {{ $apartment->status === 'available' ? 'Доступно' : 'Арендовано' }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 border-y border-gray-100 py-6">
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-sm mb-1"><i class="fas fa-door-open mr-1"></i> Комнат</span>
                            <span class="font-semibold text-gray-900">{{ $apartment->rooms }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-sm mb-1"><i class="fas fa-vector-square mr-1"></i> Площадь</span>
                            <span class="font-semibold text-gray-900">{{ $apartment->area }} м²</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-sm mb-1"><i class="fas fa-layer-group mr-1"></i> Этаж</span>
                            <span class="font-semibold text-gray-900">{{ $apartment->floor ?? '-' }} / {{ $apartment->total_floors ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-sm mb-1"><i class="fas fa-home mr-1"></i> Тип</span>
                            <span class="font-semibold text-gray-900">{{ $apartment->type }}</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="font-bold text-xl mb-4 text-gray-900">Описание</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $apartment->description }}</p>
                    </div>

                    @if($apartment->amenities)
                    <div class="mb-8">
                        <h3 class="font-bold text-xl mb-4 text-gray-900">Что есть в квартире</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(json_decode($apartment->amenities, true) ?? [] as $amenity)
                                <span class="bg-gray-50 border border-gray-200 px-4 py-2 rounded-xl text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i> {{ $amenity }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-xl shadow-gray-200/50">
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                                <span class="text-gray-500">/ сутки</span>
                            </div>

                            @auth
                                @if($apartment->status === 'available')
                                <form action="{{ route('bookings.create', $apartment) }}" method="GET" id="bookingForm" class="space-y-4">
                                    <div class="grid grid-cols-2 gap-2 p-1 bg-gray-50 rounded-2xl border border-gray-200">
                                        <div class="p-2 relative">
                                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-1">Заезд</label>
                                            <input type="date" name="check_in" id="check_in" class="w-full bg-transparent text-sm focus:outline-none text-gray-700" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        </div>
                                        <div class="p-2 relative border-l border-gray-200">
                                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-1">Выезд</label>
                                            <input type="date" name="check_out" id="check_out" class="w-full bg-transparent text-sm focus:outline-none text-gray-700" required min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                                        </div>
                                    </div>

                                    <div id="priceCalculator" class="hidden border-t border-gray-100 pt-4 mt-4 space-y-3">
                                        <div class="flex justify-between text-gray-600">
                                            <span id="calcNights">{{ number_format($apartment->price, 0, '', ' ') }} ₽ × 0 ночей</span>
                                            <span id="calcBasePrice">0 ₽</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600">
                                            <span class="underline decoration-dotted cursor-help" title="Сервисный сбор платформы">Сбор за услуги</span>
                                            <span>1 500 ₽</span>
                                        </div>
                                        <div class="flex justify-between font-bold text-lg text-gray-900 pt-3 border-t border-gray-200">
                                            <span>Итого</span>
                                            <span id="calcTotalPrice">0 ₽</span>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold px-6 py-4 rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-indigo-200">
                                        Забронировать
                                    </button>
                                    <p class="text-center text-gray-400 text-xs mt-3">Пока вы ничего не платите</p>
                                </form>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const checkIn = document.getElementById('check_in');
                                        const checkOut = document.getElementById('check_out');
                                        const calc = document.getElementById('priceCalculator');
                                        const calcNights = document.getElementById('calcNights');
                                        const calcBasePrice = document.getElementById('calcBasePrice');
                                        const calcTotalPrice = document.getElementById('calcTotalPrice');
                                        const pricePerNight = {{ $apartment->price }};
                                        const serviceFee = 1500;

                                        function calculate() {
                                            if(checkIn.value && checkOut.value) {
                                                const d1 = new Date(checkIn.value);
                                                const d2 = new Date(checkOut.value);
                                                const diffTime = Math.abs(d2 - d1);
                                                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

                                                if(diffDays > 0 && d2 > d1) {
                                                    const base = diffDays * pricePerNight;
                                                    const total = base + serviceFee;
                                                    
                                                    calcNights.textContent = pricePerNight.toLocaleString('ru-RU') + ' ₽ × ' + diffDays + ' ночей';
                                                    calcBasePrice.textContent = base.toLocaleString('ru-RU') + ' ₽';
                                                    calcTotalPrice.textContent = total.toLocaleString('ru-RU') + ' ₽';
                                                    calc.classList.remove('hidden');
                                                } else {
                                                    calc.classList.add('hidden');
                                                }
                                            }
                                        }

                                        checkIn.addEventListener('change', calculate);
                                        checkOut.addEventListener('change', calculate);
                                    });
                                </script>
                                @endif
                            @else
                                <div class="bg-gray-50 p-6 rounded-2xl text-center">
                                    <p class="text-gray-600 mb-4">Войдите в аккаунт, чтобы забронировать жилье</p>
                                    <a href="{{ route('login') }}" class="block w-full bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">Войти</a>
                                </div>
                            @endauth
                        </div>

                        @if($apartment->agent)
                        <div class="mt-6 flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg text-white text-xl font-bold border-2 border-white">
                                {{ substr($apartment->agent->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Владелец / Агент</p>
                                <p class="font-bold text-gray-900">{{ $apartment->agent->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection