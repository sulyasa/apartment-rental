<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'apartment_id' => Apartment::factory(),
            'user_id' => User::factory(),
            'check_in' => fake()->dateTimeBetween('+1 week', '+2 months'),
            'check_out' => fake()->dateTimeBetween('+2 weeks', '+3 months'),
            'total_price' => fake()->numberBetween(20000, 200000),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}