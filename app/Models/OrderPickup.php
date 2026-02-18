<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shop_id',
        'status',
        'picked_up_at',
        'pickup_note',
    ];

    protected function casts(): array
    {
        return [
            'picked_up_at' => 'datetime',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

