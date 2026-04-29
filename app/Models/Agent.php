<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'bio',
        'experience_years',
        'rating',
        'total_bookings',
        'commission_rate',
        'status',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'experience_years' => 'integer',
        'total_bookings' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'agent_id');
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }
}