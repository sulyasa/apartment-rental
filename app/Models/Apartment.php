<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_id',
        'title',
        'description',
        'address',
        'city',
        'price',
        'rooms',
        'floor',
        'total_floors',
        'area',
        'type',
        'status',
        'amenities',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'integer',
        'rooms' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAmenitiesArray()
    {
        return $this->amenities ? json_decode($this->amenities, true) : [];
    }
}