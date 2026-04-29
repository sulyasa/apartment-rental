<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем пользователей
        $user1 = User::create([
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+7 999 123-45-67',
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Петр Петров',
            'email' => 'petr@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+7 999 234-56-78',
            'role' => 'user',
        ]);

        // Создаем агентов
        $agentUser1 = User::create([
            'name' => 'Агент Мария',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+7 999 345-67-89',
            'role' => 'agent',
        ]);

        $agentUser2 = User::create([
            'name' => 'Агент Алексей',
            'email' => 'alex@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+7 999 456-78-90',
            'role' => 'agent',
        ]);

        Agent::create([
            'user_id' => $agentUser1->id,
            'license_number' => 'АГ-001234',
            'bio' => 'Опытный риелтор с 5-летним стажем работы. Специализируюсь на аренде квартир в центре города.',
            'experience_years' => 5,
            'rating' => 4.8,
            'total_bookings' => 45,
            'commission_rate' => 10.00,
            'status' => 'active',
        ]);

        Agent::create([
            'user_id' => $agentUser2->id,
            'license_number' => 'АГ-002345',
            'bio' => 'Профессионал с 3-летним опытом. Помогу подобрать идеальную квартиру по оптимальной цене.',
            'experience_years' => 3,
            'rating' => 4.5,
            'total_bookings' => 28,
            'commission_rate' => 12.00,
            'status' => 'active',
        ]);

        // Создаем квартиры
        $apartments = [
            [
                'user_id' => $user1->id,
                'agent_id' => $agentUser1->id,
                'title' => 'Уютная 2-комнатная квартира в центре',
                'description' => 'Светлая квартира с евроремонтом в самом центре города. В шаговой доступности метро, магазины, кафе. Идеально для семьи или пары.',
                'address' => 'ул. Ленина, 25',
                'city' => 'Москва',
                'price' => 45000,
                'rooms' => 2,
                'floor' => 5,
                'total_floors' => 12,
                'area' => 65,
                'type' => 'flat',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Стиральная машина', 'Холодильник', 'Кондиционер', 'Балкон']),
            ],
            [
                'user_id' => $user1->id,
                'agent_id' => $agentUser1->id,
                'title' => 'Студия в новом ЖК',
                'description' => 'Современная студия в новом жилом комплексе. Современный ремонт, вся необходимая техника. Рядом парк и детский сад.',
                'address' => 'пр-т Мира, 15',
                'city' => 'Москва',
                'price' => 35000,
                'rooms' => 1,
                'floor' => 8,
                'total_floors' => 25,
                'area' => 35,
                'type' => 'studio',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Стиральная машина', 'Посудомоечная машина', 'Кондиционер']),
            ],
            [
                'user_id' => $user2->id,
                'agent_id' => $agentUser2->id,
                'title' => '3-комнатная квартира с видом на парк',
                'description' => 'Просторная квартира в тихом районе. Рядом парк, школа, детский сад. Отличный вариант для семьи с детьми.',
                'address' => 'ул. Садовая, 42',
                'city' => 'Санкт-Петербург',
                'price' => 55000,
                'rooms' => 3,
                'floor' => 3,
                'total_floors' => 9,
                'area' => 85,
                'type' => 'flat',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Стиральная машина', 'Холодильник', 'Балкон', 'Парковка']),
            ],
            [
                'user_id' => $user2->id,
                'agent_id' => $agentUser2->id,
                'title' => 'Комната в коммуналке',
                'description' => 'Уютная комната в историческом доме. Центр города, отличная транспортная доступность.',
                'address' => 'наб. канала Грибоедова, 8',
                'city' => 'Санкт-Петербург',
                'price' => 18000,
                'rooms' => 1,
                'floor' => 4,
                'total_floors' => 5,
                'area' => 18,
                'type' => 'room',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Холодильник']),
            ],
            [
                'user_id' => $user1->id,
                'agent_id' => $agentUser1->id,
                'title' => 'Таунхаус в пригороде',
                'description' => 'Двухуровневый таунхаус с гаражом. Свежий воздух, тишина, при этом недалеко от города.',
                'address' => 'пос. Барвиха, 55',
                'city' => 'Москва',
                'price' => 75000,
                'rooms' => 4,
                'floor' => 2,
                'total_floors' => 2,
                'area' => 150,
                'type' => 'house',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Стиральная машина', 'Холодильник', 'Камин', 'Гараж', 'Баня']),
            ],
            [
                'user_id' => $user2->id,
                'agent_id' => null,
                'title' => '1-комнатная квартира возле метро',
                'description' => 'Квартира в 5 минутах ходьбы от метро. Всё необходимое рядом. Идеально для студента или молодого специалиста.',
                'address' => 'ул. Пушкина, 12',
                'city' => 'Казань',
                'price' => 22000,
                'rooms' => 1,
                'floor' => 7,
                'total_floors' => 9,
                'area' => 32,
                'type' => 'flat',
                'status' => 'available',
                'amenities' => json_encode(['WiFi', 'Стиральная машина', 'Холодильник']),
            ],
        ];

        foreach ($apartments as $apartment) {
            Apartment::create($apartment);
        }

        // Создаем тестовые бронирования
        Booking::create([
            'apartment_id' => 1,
            'user_id' => $user1->id,
            'check_in' => now()->addDays(5),
            'check_out' => now()->addDays(12),
            'total_price' => 315000,
            'status' => 'confirmed',
            'notes' => 'Хочу арендовать на неделю',
        ]);

        Booking::create([
            'apartment_id' => 3,
            'user_id' => $user2->id,
            'check_in' => now()->addDays(10),
            'check_out' => now()->addDays(17),
            'total_price' => 385000,
            'status' => 'pending',
            'notes' => 'Интересует долгосрочная аренда',
        ]);
    }
}