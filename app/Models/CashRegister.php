<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'is_active',
        'opening_balance'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_balance' => 'decimal:2'
    ];

    // Relationships
    public function sessions()
    {
        return $this->hasMany(CashRegisterSession::class);
    }

    public function posOrders()
    {
        return $this->hasManyThrough(PosOrder::class, CashRegisterSession::class);
    }
}