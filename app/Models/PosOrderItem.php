<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pos_order_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'line_total',
        'tax_rate',
        'tax_amount'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2'
    ];

    // Relationships
    public function posOrder()
    {
        return $this->belongsTo(PosOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}