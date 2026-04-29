<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_apartments_index_loads()
    {
        $response = $this->get('/apartments');
        $response->assertStatus(200);
    }

    public function test_agents_index_loads()
    {
        $response = $this->get('/agents');
        $response->assertStatus(200);
    }

    public function test_apartment_filter_by_city()
    {
        $response = $this->get('/apartments?city=Москва');
        $response->assertStatus(200);
    }

    public function test_apartment_filter_by_type()
    {
        $response = $this->get('/apartments?type=flat');
        $response->assertStatus(200);
    }

    public function test_apartment_filter_by_price()
    {
        $response = $this->get('/apartments?min_price=10000&max_price=50000');
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_agent_dashboard()
    {
        $response = $this->get('/agent/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_apartment()
    {
        $response = $this->get('/apartments/create');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_my_bookings()
    {
        $response = $this->get('/my-bookings');
        $response->assertRedirect('/login');
    }
}