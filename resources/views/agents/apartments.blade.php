@extends('layouts.app')

@section('title', 'Квартиры агента')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Мои квартиры</h1>
        <a href="{{ route('apartments.create') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
            <i class="fas fa-plus"></i> Добавить квартиру
        </a>
    </div>
    
    @if($apartments->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">У вас пока нет квартир.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($apartments as $apartment)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-building text-5xl text-white opacity-50"></i>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-800">{{ $apartment->title }}</h3>
                            <span class="px-2 py-1 rounded text-xs
                                @if($apartment->status === 'available') bg-green-100 text-green-800
                                @elseif($apartment->status === 'rented') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $apartment->status }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-2">{{ $apartment->city }}, {{ $apartment->address }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-indigo-600">{{ number_format($apartment->price, 0, '', ' ') }} ₽</span>
                            <a href="{{ route('apartments.show', $apartment) }}" class="text-indigo-600 hover:underline">Подробнее</a>
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
@endsection