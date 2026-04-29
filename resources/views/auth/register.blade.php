@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-8">Регистрация</h1>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Имя</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Пароль</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Зарегистрироваться
            </button>
        </form>
        
        <p class="text-center mt-6 text-gray-600">
            Уже есть аккаунт? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Вход</a>
        </p>
    </div>
</div>
@endsection