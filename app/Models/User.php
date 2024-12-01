<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
    ];

    protected $hidden = [];

    protected $casts = [];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    
}
