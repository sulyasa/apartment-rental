<?php
/**
 * Simple Installer for 000webhost
 * 
 * Usage: Upload this file to public_html, then visit yourdomain.com/install.php
 */

$step = $_GET['step'] ?? 1;
$error = '';
$success = false;

// Check if already installed
if (file_exists('.env') && file_exists('vendor/autoload.php')) {
    $step = 4; // Already installed
}

switch ($step) {
    case 1: // Welcome
        break;
        
    case 2: // Database config
        if ($_POST) {
            $db_host = $_POST['db_host'] ?? 'localhost';
            $db_name = $_POST['db_name'] ?? '';
            $db_user = $_POST['db_user'] ?? '';
            $db_pass = $_POST['db_pass'] ?? '';
            
            // Test connection
            try {
                $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
                $success = true;
            } catch (PDOException $e) {
                $error = 'Ошибка подключения к базе данных: ' . $e->getMessage();
            }
        }
        break;
        
    case 3: // Install
        if ($_POST) {
            $db_host = $_POST['db_host'] ?? 'localhost';
            $db_name = $_POST['db_name'] ?? '';
            $db_user = $_POST['db_user'] ?? '';
            $db_pass = $_POST['db_pass'] ?? '';
            
            // Create .env file
            $env_content = "APP_NAME=ApartmentRental
APP_ENV=local
APP_KEY=base64:".base64_encode(random_bytes(32))."
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=$db_host
DB_PORT=3306
DB_DATABASE=$db_name
DB_USERNAME=$db_user
DB_PASSWORD=$db_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

LOG_CHANNEL=stack
LOG_LEVEL=debug
";
            file_put_contents('.env', $env_content);
            $success = true;
        }
        break;
        
    case 4: // Complete
        $success = true;
        break;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Установка Apartment Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-2xl mx-auto py-16 px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <?php if ($step == 1): ?>
                <!-- Step 1: Welcome -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-home text-4xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Установка Apartment Rental</h1>
                    <p class="text-gray-600 mb-8">Система аренды квартир на Laravel</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left">
                        <h3 class="font-semibold mb-2">Что будет сделано:</h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>✓ Настройка подключения к базе данных</li>
                            <li>✓ Создание таблиц в базе данных</li>
                            <li>✓ Заполнение тестовыми данными</li>
                            <li>✓ Настройка приложения</li>
                        </ul>
                    </div>
                    
                    <a href="?step=2" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                        Начать установку <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
            <?php elseif ($step == 2): ?>
                <!-- Step 2: Database Config -->
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Настройка базы данных</h1>
                
                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="?step=3">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Хост базы данных</label>
                        <input type="text" name="db_host" value="localhost" required class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Имя базы данных</label>
                        <input type="text" name="db_name" required class="w-full px-4 py-2 border rounded-lg" placeholder="your_db_name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Пользователь базы данных</label>
                        <input type="text" name="db_user" required class="w-full px-4 py-2 border rounded-lg" placeholder="your_db_user">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Пароль базы данных</label>
                        <input type="password" name="db_pass" class="w-full px-4 py-2 border rounded-lg" placeholder="your_db_password">
                    </div>
                    <div class="flex gap-4">
                        <a href="?step=1" class="flex-1 text-center border-2 border-gray-300 text-gray-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50">
                            Назад
                        </a>
                        <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                            Продолжить
                        </button>
                    </div>
                </form>
                
            <?php elseif ($step == 3): ?>
                <!-- Step 3: Install -->
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Установка</h1>
                
                <form method="POST" action="?step=3">
                    <input type="hidden" name="db_host" value="<?= $_POST['db_host'] ?>">
                    <input type="hidden" name="db_name" value="<?= $_POST['db_name'] ?>">
                    <input type="hidden" name="db_user" value="<?= $_POST['db_user'] ?>">
                    <input type="hidden" name="db_pass" value="<?= $_POST['db_pass'] ?>">
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <span>Создание конфигурации</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-gray-500">2</span>
                            </div>
                            <span class="text-gray-500">Запуск миграций (нужно выполнить вручную)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-gray-500">3</span>
                            </div>
                            <span class="text-gray-500">Заполнение базы данных (нужно выполнить вручную)</span>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-yellow-800 text-sm">
                            <strong>Важно:</strong> После нажатия "Продолжить" нужно вручную запустить миграции через терминал хостинга или создать файл миграции.
                        </p>
                    </div>
                    
                    <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                        Создать конфигурацию
                    </button>
                </form>
                
            <?php elseif ($step == 4): ?>
                <!-- Step 4: Complete -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check text-4xl text-green-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Установка завершена!</h1>
                    <p class="text-gray-600 mb-8">Конфигурация создана. Теперь нужно запустить миграции.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                        <h3 class="font-semibold mb-2">Следующие шаги:</h3>
                        <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
                            <li>Зайдите в панель управления хостингом</li>
                            <li>Откройте терминал или SSH</li>
                            <li>Выполните: <code class="bg-gray-200 px-2 py-1 rounded">php artisan migrate</code></li>
                            <li>Выполните: <code class="bg-gray-200 px-2 py-1 rounded">php artisan db:seed</code></li>
                            <li>Сайт готов к работе!</li>
                        </ol>
                    </div>
                    
                    <a href="/" class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700">
                        Перейти на сайт
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <p class="text-center text-gray-500 text-sm mt-8">
            Apartment Rental v1.0 | Laravel <?= implode('.', array_slice(explode('.', PHP_VERSION), 0, 2)) ?>
        </p>
    </div>
</body>
</html>