<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory extends Factory
{
    protected $model = Apartment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'agent_id' => null,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'city' => fake()->randomElement(['Москва', 'Санкт-Петербург', 'Казань', 'Екатеринбург', 'Новосибирск']),
            'price' => fake()->numberBetween(15000, 100000),
            'rooms' => fake()->numberBetween(1, 5),
            'floor' => fake()->numberBetween(1, 25),
            'total_floors' => fake()->numberBetween(5, 30),
            'area' => fake()->numberBetween(20, 150),
            'type' => fake()->randomElement(['flat', 'house', 'studio', 'room']),
            'status' => 'available',
            'amenities' => json_encode(fake()->randomElements(['WiFi', 'Стиральная машина', 'Холодильник', 'Кондиционер', 'Балкон', 'Парковка'], 3)),
        ];
    }

    public function withAgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'agent_id' => User::factory(),
        ]);
    }

    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rented',
        ]);
    }
}