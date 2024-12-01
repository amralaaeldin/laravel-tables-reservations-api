<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'customer_id',
        'from',
        'to',
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
