<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Аренда квартир')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        <i class="fas fa-home"></i> RentHome
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('apartments.index') }}" class="text-gray-600 hover:text-indigo-600">Квартиры</a>
                    <a href="{{ route('agents.index') }}" class="text-gray-600 hover:text-indigo-600">Агенты</a>
                    @auth
                        <a href="{{ route('bookings.my') }}" class="text-gray-600 hover:text-indigo-600">Мои бронирования</a>
                        @if(Auth::user()->isAgent())
                            <a href="{{ route('agent.dashboard') }}" class="text-gray-600 hover:text-indigo-600">Панель агента</a>
                        @else
                            <a href="{{ route('agent.become') }}" class="text-gray-600 hover:text-indigo-600">Стать агентом</a>
                        @endif
                        <div class="relative group">
                            <button class="text-gray-600 hover:text-indigo-600">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden group-hover:block z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Войти</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @yield('content')

    <footer class="bg-gray-800 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">RentHome</h3>
                    <p class="text-gray-400">Лучший сервис для аренды квартир. Найдите своё идеальное жильё.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Навигация</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Главная</a></li>
                        <li><a href="{{ route('apartments.index') }}" class="hover:text-white">Квартиры</a></li>
                        <li><a href="{{ route('agents.index') }}" class="hover:text-white">Агенты</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Категории</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('apartments.index', ['type' => 'flat']) }}" class="hover:text-white">Квартиры</a></li>
                        <li><a href="{{ route('apartments.index', ['type' => 'house']) }}" class="hover:text-white">Дома</a></li>
                        <li><a href="{{ route('apartments.index', ['type' => 'studio']) }}" class="hover:text-white">Студии</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Контакты</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone"></i> +7 (999) 123-45-67</li>
                        <li><i class="fas fa-envelope"></i> info@renthome.ru</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                © 2024 RentHome. Все права защищены.
            </div>
        </div>
    </footer>
</body>
</html>