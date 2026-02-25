<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'cash_register_session_id',
        'customer_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'change_amount',
        'payment_method',
        'status'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function cashRegisterSession()
    {
        return $this->belongsTo(CashRegisterSession::class);
    }

    public function orderItems()
    {
        return $this->hasMany(PosOrderItem::class);
    }

    // Accessors
    public function getFormattedOrderNumberAttribute()
    {
        return '#' . str_pad($this->order_number, 6, '0', STR_PAD_LEFT);
    }

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'cash' => 'Espèces',
            'card' => 'Carte Bancaire',
            'mobile' => 'Mobile Money',
            'transfer' => 'Virement'
        ];

        return $labels[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'En Attente',
            'completed' => 'Complété',
            'cancelled' => 'Annulé'
        ];

        return $labels[$this->status] ?? $this->status;
    }
    
    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}