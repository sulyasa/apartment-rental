@extends('layouts.app')

@section('title', 'Мои бронирования')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Мои бронирования</h1>
    
    @if($bookings->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-calendar text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">У вас пока нет бронирований.</p>
            <a href="{{ route('apartments.index') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Найти квартиру
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">{{ $booking->apartment->title }}</h3>
                            <p class="text-gray-600 mt-1">
                                <i class="fas fa-map-marker-alt"></i> {{ $booking->apartment->city }}, {{ $booking->apartment->address }}
                            </p>
                            <div class="flex items-center space-x-6 mt-3 text-sm text-gray-600">
                                <span><i class="fas fa-calendar"></i> Заезд: {{ $booking->check_in->format('d.m.Y') }}</span>
                                <span><i class="fas fa-calendar"></i> Выезд: {{ $booking->check_out->format('d.m.Y') }}</span>
                                <span><i class="fas fa-ruble-sign"></i> {{ number_format($booking->total_price, 0, '', ' ') }} ₽</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded text-sm font-semibold
                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($booking->status === 'pending') Ожидает
                                @elseif($booking->status === 'confirmed') Подтверждено
                                @elseif($booking->status === 'cancelled') Отменено
                                @else Завершено @endif
                            </span>
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Вы уверены?')">
                                        Отменить
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection