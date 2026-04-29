@extends('layouts.app')

@section('title', 'Панель агента')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Панель управления агента</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Квартир</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_apartments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Бронирований</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['active_bookings'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ruble-sign text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Доход</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_earnings'], 0, '', ' ') }} ₽</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Рейтинг</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['rating'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Мои квартиры</h2>
            <a href="{{ route('agent.apartments') }}" class="text-indigo-600 hover:underline">Управлять квартирами →</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Бронирования</h2>
            <a href="{{ route('agent.bookings') }}" class="text-indigo-600 hover:underline">Управлять бронированиями →</a>
        </div>
    </div>
    
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Последние бронирования</h2>
        @if($recentBookings->isEmpty())
            <p class="text-gray-600">Пока нет бронирований.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3">Квартира</th>
                            <th class="text-left py-3">Клиент</th>
                            <th class="text-left py-3">Даты</th>
                            <th class="text-left py-3">Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr class="border-b">
                            <td class="py-3">{{ $booking->apartment->title }}</td>
                            <td class="py-3">{{ $booking->user->name }}</td>
                            <td class="py-3">{{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded text-sm 
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection