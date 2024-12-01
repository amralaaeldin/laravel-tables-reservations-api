<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'meal_id',
        'quantity',
        'amount_to_pay',
    ];

    protected function amountToPay(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value / 100,
            set: fn(string $value) => $value * 100,
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
