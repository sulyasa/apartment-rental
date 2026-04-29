<?php
/**
 * Database Migration Runner for 000webhost
 * 
 * Usage: Upload to public_html and visit yourdomain.com/migrate.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Capsule\Manager as Capsule;

echo "<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Миграция базы данных</title>
    <script src='https://cdn.tailwindcss.com'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
</head>
<body class='bg-gray-100 min-h-screen'>
    <div class='max-w-2xl mx-auto py-16 px-4'>
        <div class='bg-white rounded-2xl shadow-lg p-8'>";

try {
    // Check database connection
    Capsule::connection()->getPdo();
    echo "<div class='text-center'>
            <div class='w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6'>
                <i class='fas fa-database text-4xl text-green-600'></i>
            </div>
            <h1 class='text-2xl font-bold text-gray-800 mb-4'>База данных подключена!</h1>
            <p class='text-gray-600 mb-6'>Подключение успешно.</p>
          </div>";
    
    // Run migrations
    echo "<div class='mt-6'>";
    echo "<h3 class='font-semibold mb-4'>Запуск миграций...</h3>";
    
    // Create users table
    Schema::create('users', function ($table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('phone')->nullable();
        $table->text('avatar')->nullable();
        $table->enum('role', ['user', 'agent', 'admin'])->default('user');
        $table->rememberToken();
        $table->timestamps();
    });
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Таблица users создана</p>";
    
    // Create apartments table
    Schema::create('apartments', function ($table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('title');
        $table->text('description');
        $table->string('address');
        $table->string('city');
        $table->decimal('price', 10, 2);
        $table->integer('rooms');
        $table->integer('floor')->nullable();
        $table->integer('total_floors')->nullable();
        $table->integer('area');
        $table->enum('type', ['flat', 'house', 'room', 'studio'])->default('flat');
        $table->enum('status', ['available', 'rented', 'unavailable'])->default('available');
        $table->text('amenities')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();
    });
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Таблица apartments создана</p>";
    
    // Create bookings table
    Schema::create('bookings', function ($table) {
        $table->id();
        $table->foreignId('apartment_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('check_in');
        $table->date('check_out');
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Таблица bookings создана</p>";
    
    // Create agents table
    Schema::create('agents', function ($table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('license_number')->nullable();
        $table->text('bio')->nullable();
        $table->integer('experience_years')->default(0);
        $table->decimal('rating', 3, 2)->default(0);
        $table->integer('total_bookings')->default(0);
        $table->decimal('commission_rate', 5, 2)->default(10.00);
        $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
        $table->timestamps();
    });
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Таблица agents создана</p>";
    
    echo "</div>";
    
    // Run seeder
    echo "<div class='mt-6 pt-6 border-t'>";
    echo "<h3 class='font-semibold mb-4'>Заполнение тестовыми данными...</h3>";
    
    // Create users
    $user1 = \App\Models\User::create([
        'name' => 'Иван Иванов',
        'email' => 'ivan@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'phone' => '+7 999 123-45-67',
        'role' => 'user',
    ]);
    
    $user2 = \App\Models\User::create([
        'name' => 'Петр Петров',
        'email' => 'petr@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'phone' => '+7 999 234-56-78',
        'role' => 'user',
    ]);
    
    $agentUser1 = \App\Models\User::create([
        'name' => 'Агент Мария',
        'email' => 'maria@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'phone' => '+7 999 345-67-89',
        'role' => 'agent',
    ]);
    
    $agentUser2 = \App\Models\User::create([
        'name' => 'Агент Алексей',
        'email' => 'alex@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'phone' => '+7 999 456-78-90',
        'role' => 'agent',
    ]);
    
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Пользователи созданы</p>";
    
    // Create agents
    \App\Models\Agent::create([
        'user_id' => $agentUser1->id,
        'license_number' => 'АГ-001234',
        'bio' => 'Опытный риелтор с 5-летним стажем работы.',
        'experience_years' => 5,
        'rating' => 4.8,
        'total_bookings' => 45,
        'commission_rate' => 10.00,
        'status' => 'active',
    ]);
    
    \App\Models\Agent::create([
        'user_id' => $agentUser2->id,
        'license_number' => 'АГ-002345',
        'bio' => 'Профессионал с 3-летним опытом.',
        'experience_years' => 3,
        'rating' => 4.5,
        'total_bookings' => 28,
        'commission_rate' => 12.00,
        'status' => 'active',
    ]);
    
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Агенты созданы</p>";
    
    // Create apartments
    $apartments = [
        ['user_id' => $user1->id, 'agent_id' => $agentUser1->id, 'title' => 'Уютная 2-комнатная квартира в центре', 'description' => 'Светлая квартира с евроремонтом в самом центре города.', 'address' => 'ул. Ленина, 25', 'city' => 'Москва', 'price' => 45000, 'rooms' => 2, 'floor' => 5, 'total_floors' => 12, 'area' => 65, 'type' => 'flat'],
        ['user_id' => $user1->id, 'agent_id' => $agentUser1->id, 'title' => 'Студия в новом ЖК', 'description' => 'Современная студия в новом жилом комплексе.', 'address' => 'пр-т Мира, 15', 'city' => 'Москва', 'price' => 35000, 'rooms' => 1, 'floor' => 8, 'total_floors' => 25, 'area' => 35, 'type' => 'studio'],
        ['user_id' => $user2->id, 'agent_id' => $agentUser2->id, 'title' => '3-комнатная квартира с видом на парк', 'description' => 'Просторная квартира в тихом районе.', 'address' => 'ул. Садовая, 42', 'city' => 'Санкт-Петербург', 'price' => 55000, 'rooms' => 3, 'floor' => 3, 'total_floors' => 9, 'area' => 85, 'type' => 'flat'],
        ['user_id' => $user2->id, 'agent_id' => $agentUser2->id, 'title' => 'Комната в коммуналке', 'description' => 'Уютная комната в историческом доме.', 'address' => 'наб. канала Грибоедова, 8', 'city' => 'Санкт-Петербург', 'price' => 18000, 'rooms' => 1, 'floor' => 4, 'total_floors' => 5, 'area' => 18, 'type' => 'room'],
        ['user_id' => $user1->id, 'agent_id' => $agentUser1->id, 'title' => 'Таунхаус в пригороде', 'description' => 'Двухуровневый таунхаус с гаражом.', 'address' => 'пос. Барвиха, 55', 'city' => 'Москва', 'price' => 75000, 'rooms' => 4, 'floor' => 2, 'total_floors' => 2, 'area' => 150, 'type' => 'house'],
        ['user_id' => $user2->id, 'agent_id' => null, 'title' => '1-комнатная квартира возле метро', 'description' => 'Квартира в 5 минутах ходьбы от метро.', 'address' => 'ул. Пушкина, 12', 'city' => 'Казань', 'price' => 22000, 'rooms' => 1, 'floor' => 7, 'total_floors' => 9, 'area' => 32, 'type' => 'flat'],
    ];
    
    foreach ($apartments as $apt) {
        $apt['status'] = 'available';
        $apt['amenities'] = json_encode(['WiFi', 'Стиральная машина', 'Холодильник']);
        \App\Models\Apartment::create($apt);
    }
    
    echo "<p class='text-green-600'><i class='fas fa-check'></i> Квартиры созданы</p>";
    
    echo "</div>";
    
    echo "<div class='mt-8 text-center'>
            <div class='w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4'>
                <i class='fas fa-check-circle text-4xl text-green-600'></i>
            </div>
            <h2 class='text-xl font-bold text-gray-800 mb-2'>Установка завершена!</h2>
            <p class='text-gray-600 mb-6'>Сайт готов к работе.</p>
            <a href='/' class='inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700'>
                Перейти на сайт
            </a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='text-center'>
            <div class='w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4'>
                <i class='fas fa-exclamation-triangle text-4xl text-red-600'></i>
            </div>
            <h2 class='text-xl font-bold text-gray-800 mb-2'>Ошибка!</h2>
            <p class='text-red-600 mb-4'>" . $e->getMessage() . "</p>
            <p class='text-gray-600 text-sm'>Проверьте настройки базы данных в файле .env</p>
          </div>";
}

echo "      </div>
    </div>
</body>
</html>";