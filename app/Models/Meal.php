<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'discount_percentage',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value / 100,
            set: fn(string $value) => $value * 100,
        );
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function quantityAvailable($date)
    {
        return $this->quantity - $this->orderDetails()->whereHas('order', function ($query) use ($date) {
            $query->whereHas('reservation', function ($query) use ($date) {
                $query->whereDate('from', $date);
            });
        })->sum('quantity');
    }

    public function discountAmount()
    {
        return $this->price * $this->discount_percentage / 100;
    }

    public function priceAfterDiscount()
    {
        return $this->price - $this->discountAmount();
    }
}
