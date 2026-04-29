@extends('layouts.app')

@section('title', 'Бронирования - Панель агента')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Управление бронированиями</h1>
    
    @if($bookings->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-calendar text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Нет бронирований.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Квартира</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Клиент</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Даты</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Сумма</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Статус</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4">
                            <a href="{{ route('apartments.show', $booking->apartment) }}" class="text-indigo-600 hover:underline">
                                {{ $booking->apartment->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 font-semibold">{{ number_format($booking->total_price, 0, '', ' ') }} ₽</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-sm 
                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($booking->status === 'pending')
                            <form action="{{ route('agent.bookings.update', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="text-green-600 hover:underline mr-3">
                                    <i class="fas fa-check"></i> Подтвердить
                                </button>
                            </form>
                            <form action="{{ route('agent.bookings.update', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="text-red-600 hover:underline">
                                    <i class="fas fa-times"></i> Отклонить
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection