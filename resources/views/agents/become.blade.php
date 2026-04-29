@extends('layouts.app')

@section('title', 'Стать агентом')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-8">Стать агентом</h1>
        
        <p class="text-gray-600 mb-8 text-center">
            Заполните форму ниже, чтобы стать агентом по аренде недвижимости и получить доступ к расширенным функциям.
        </p>
        
        <form method="POST" action="{{ route('agent.become') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Номер лицензии (необязательно)</label>
                <input type="text" name="license_number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="АГ-123456">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Опыт работы (лет)</label>
                <input type="number" name="experience_years" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="0">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">О себе</label>
                <textarea name="bio" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Расскажите о своём опыте..."></textarea>
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                Стать агентом
            </button>
        </form>
    </div>
</div>
@endsection