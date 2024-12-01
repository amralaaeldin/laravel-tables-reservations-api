<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'waiter_id',
        'paid',
    ];

    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value / 100,
            set: fn(string $value) => $value * 100,
        );
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function totalBeforeDiscount()
    {
        return $this->details->sum(function ($detail) {
            return $detail->meal->price * $detail->quantity;
        });
    }

    public function totalAmountToPay()
    {
        return $this->details->sum('amount_to_pay');
    }

    public function totalAmountDue()
    {
        return $this->totalAmountToPay() - $this->paid;
    }

    public function table()
    {
        return $this->reservation->table;
    }
}
