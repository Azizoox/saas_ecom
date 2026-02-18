<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shop_id',
        'invoice_number',
        'issued_at',
        'subtotal',
        'tax_total',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'subtotal' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (blank($invoice->invoice_number)) {
                $invoice->invoice_number = self::generateInvoiceNumber();
            }
            if (blank($invoice->issued_at)) {
                $invoice->issued_at = now()->toDateString();
            }
        });
    }

    public static function generateInvoiceNumber(): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
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

