<?php

namespace Tests\Unit;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_apartment_can_be_created()
    {
        $user = User::factory()->create();
        
        $apartment = Apartment::create([
            'user_id' => $user->id,
            'title' => 'Test Apartment',
            'description' => 'Test description',
            'address' => 'Test address',
            'city' => 'Москва',
            'price' => 35000,
            'rooms' => 2,
            'area' => 65,
            'type' => 'flat',
            'status' => 'available',
        ]);

        $this->assertDatabaseHas('apartments', [
            'title' => 'Test Apartment',
            'city' => 'Москва',
        ]);
    }

    public function test_booking_can_be_created()
    {
        $user = User::factory()->create();
        $apartment = Apartment::factory()->create(['user_id' => $user->id]);
        
        $booking = Booking::create([
            'apartment_id' => $apartment->id,
            'user_id' => $user->id,
            'check_in' => now()->addDays(5),
            'check_out' => now()->addDays(12),
            'total_price' => 35000 * 7,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('bookings', [
            'status' => 'pending',
        ]);
    }

    public function test_user_is_agent_method()
    {
        $user = User::factory()->create(['role' => 'user']);
        $agent = User::factory()->create(['role' => 'agent']);

        $this->assertFalse($user->isAgent());
        $this->assertTrue($agent->isAgent());
    }

    public function test_user_is_admin_method()
    {
        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertFalse($user->isAdmin());
        $this->assertTrue($admin->isAdmin());
    }

    public function test_apartment_relationships()
    {
        $user = User::factory()->create();
        $apartment = Apartment::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $apartment->owner->id);
    }

    public function test_booking_relationships()
    {
        $user = User::factory()->create();
        $apartment = Apartment::factory()->create(['user_id' => $user->id]);
        $booking = Booking::factory()->create([
            'apartment_id' => $apartment->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals($apartment->id, $booking->apartment->id);
        $this->assertEquals($user->id, $booking->user->id);
    }
}