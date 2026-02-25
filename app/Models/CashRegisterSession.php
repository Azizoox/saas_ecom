<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegisterSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_register_id',
        'user_id',
        'opened_at',
        'closed_at',
        'opening_balance',
        'expected_closing_balance',
        'actual_closing_balance',
        'difference',
        'status',
        'notes'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_balance' => 'decimal:2',
        'expected_closing_balance' => 'decimal:2',
        'actual_closing_balance' => 'decimal:2',
        'difference' => 'decimal:2'
    ];

    // Relationships
    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posOrders()
    {
        return $this->hasMany(PosOrder::class);
    }
}