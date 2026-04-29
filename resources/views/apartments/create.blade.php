@extends('layouts.app')

@section('title', 'Добавить квартиру')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-8">Добавить новую квартиру</h1>
        
        <form method="POST" action="{{ route('apartments.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Название *</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Уютная 2-комнатная квартира">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Описание *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Подробное описание квартиры..."></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Город *</label>
                    <input type="text" name="city" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Москва">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Адрес *</label>
                    <input type="text" name="address" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="ул. Ленина, 25">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Цена (₽/мес) *</label>
                    <input type="number" name="price" required min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="35000">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Комнаты *</label>
                    <input type="number" name="rooms" required min="1" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Площадь (м²) *</label>
                    <input type="number" name="area" required min="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="65">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Тип жилья *</label>
                    <select name="type" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Выберите тип</option>
                        <option value="flat">Квартира</option>
                        <option value="house">Дом</option>
                        <option value="studio">Студия</option>
                        <option value="room">Комната</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Этаж</label>
                    <input type="number" name="floor" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Всего этажей</label>
                    <input type="number" name="total_floors" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="12">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Удобства</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['WiFi', 'Стиральная машина', 'Холодильник', 'Кондиционер', 'Балкон', 'Парковка', 'Кухня', 'Телевизор'] as $amenity)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity }}" class="rounded text-indigo-600">
                            <span class="text-sm">{{ $amenity }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                Добавить квартиру
            </button>
        </form>
    </div>
</div>
@endsection