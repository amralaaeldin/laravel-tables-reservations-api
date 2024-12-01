<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeAvailable($capacity, $from, $to)
    {
        return $this->where('capacity', $capacity)->whereDoesntHave('reservations', function ($query) use ($from, $to) {
            $query->where(function ($query) use ($from) {
                $query->where('from', '<=', $from)
                    ->where('to', '>', $from);
            })
                ->orWhere(function ($query) use ($to) {
                    $query->where('from', '<', $to)
                        ->where('to', '>=', $to);
                })
                ->orWhere(function ($query) use ($from, $to) {
                    $query->where('from', '>=', $from)
                        ->where('to', '<=', $to);
                });
        });
    }

    public function isAvailable($from, $to)
    {
        return $this->reservations()
            ->where(function ($query) use ($from) {
                $query->where('from', '<=', $from)
                    ->where('to', '>', $from);
            })
            ->orWhere(function ($query) use ($to) {
                $query->where('from', '<', $to)
                    ->where('to', '>=', $to);
            })
            ->orWhere(function ($query) use ($from, $to) {
                $query->where('from', '>=', $from)
                    ->where('to', '<=', $to);
            })
            ->doesntExist();
    }
}
