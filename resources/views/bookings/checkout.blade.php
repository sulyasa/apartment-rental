@extends('layouts.app')

@section('title', 'Оформление бронирования')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('apartments.show', $apartment) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-arrow-left"></i> Назад к квартире
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">Оформление бронирования</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Детали бронирования -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Ваша поездка</h2>
                
                <div class="flex justify-between items-center pb-6 border-b border-gray-100">
                    <div>
                        <p class="font-bold text-gray-900">Даты</p>
                        <p class="text-gray-600">{{ $checkInDate->isoFormat('D MMMM') }} – {{ $checkOutDate->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                    <a href="{{ route('apartments.show', $apartment) }}" class="text-indigo-600 font-medium underline">Изменить</a>
                </div>
            </div>

            <!-- Форма оплаты -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Оплата</h2>
                
                <form action="{{ route('bookings.store', $apartment) }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="check_in" value="{{ $checkInDate->format('Y-m-d') }}">
                    <input type="hidden" name="check_out" value="{{ $checkOutDate->format('Y-m-d') }}">
                    
                    <div class="space-y-4 mb-6">
                        <label class="flex items-center justify-between p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-indigo-500 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" class="text-indigo-600 focus:ring-indigo-500 w-5 h-5" checked>
                                <span class="font-medium text-gray-900">Банковская карта</span>
                            </div>
                            <div class="flex gap-1 text-2xl text-gray-400">
                                <i class="fab fa-cc-visa text-blue-800"></i>
                                <i class="fab fa-cc-mastercard text-red-600"></i>
                                <i class="fab fa-cc-apple-pay text-black"></i>
                            </div>
                        </label>
                    </div>

                    <!-- Имитация ввода карты -->
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 mb-8 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Номер карты</label>
                            <div class="relative">
                                <input type="text" placeholder="0000 0000 0000 0000" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <i class="fas fa-credit-card absolute left-3 top-3.5 text-gray-400 text-lg"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Срок действия</label>
                                <input type="text" placeholder="ММ/ГГ" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="password" placeholder="123" maxlength="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="font-bold text-gray-900 mb-2">Пожелания (необязательно)</h3>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400" placeholder="Напишите владельцу, во сколько планируете заехать..."></textarea>
                    </div>

                    <p class="text-xs text-gray-500 mb-6">Нажимая кнопку ниже, вы соглашаетесь с правилами платформы. Это безопасный платеж. Ваша карта будет списана на сумму {{ number_format($totalPrice + 1500, 0, '', ' ') }} ₽.</p>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold text-lg px-8 py-4 rounded-2xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex justify-center items-center gap-2">
                        <i class="fas fa-lock"></i> Оплатить и забронировать
                    </button>
                </form>
            </div>
        </div>

        <!-- Сайдбар с инфой -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm sticky top-6">
                <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 bg-gray-200">
                        @if($apartment->image)
                            <img src="{{ Storage::url($apartment->image) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">{{ $apartment->type }}</p>
                        <h3 class="font-bold text-gray-900 line-clamp-2 leading-snug">{{ $apartment->title }}</h3>
                        <div class="text-sm text-gray-600 mt-1 flex items-center gap-1">
                            <i class="fas fa-star text-sm text-yellow-400"></i>
                            <span class="font-semibold text-gray-900">4.9</span>
                        </div>
                    </div>
                </div>

                <h3 class="font-bold text-xl text-gray-900 mb-4">Детализация цены</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>{{ number_format($apartment->price, 0, '', ' ') }} ₽ × {{ $nights }} ночей</span>
                        <span>{{ number_format($totalPrice, 0, '', ' ') }} ₽</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span class="underline decoration-dotted cursor-help" title="Сервисный сбор платформы">Сбор платформы</span>
                        <span>1 500 ₽</span>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <span class="font-bold text-lg text-gray-900">Итого (RUB)</span>
                    <span class="font-bold text-xl text-gray-900">{{ number_format($totalPrice + 1500, 0, '', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
