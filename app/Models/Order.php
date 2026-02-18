<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_RETURNED = 'returned';

    protected $fillable = [
        'shop_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_state',
        'shipping_country',
        'payment_method',
        'payment_status',
        'status',
        'subtotal',
        'shipping_total',
        'discount_total',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_total' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (blank($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
            if (blank($order->status)) {
                $order->status = self::STATUS_NEW;
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        // Readable + unique enough for MVP
        return 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
    }

    public static function allowedStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_PREPARING,
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED,
            self::STATUS_RETURNED,
        ];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function pickup()
    {
        return $this->hasOne(OrderPickup::class);
    }

    public function packing()
    {
        return $this->hasOne(OrderPacking::class);
    }

    public function returnRequest()
    {
        return $this->hasOne(OrderReturn::class);
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items()->sum('line_total');
        $this->subtotal = $subtotal;
        $this->total = (float) $subtotal + (float) $this->shipping_total - (float) $this->discount_total;
    }
}

