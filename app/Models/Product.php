<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'category_id',
        'reference',
        'barcode',
        'supplier',
        'brand',
        'description',
        'short_description',
        'price',
        'image',
        'images',
        'stock',
        'is_active',
        'sku',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'variants',
        'product_group_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'images' => 'array',
            'variants' => 'array',
        ];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(Product::class, 'product_group_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(Product::class, 'product_group_id');
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2, ',', ' ') . ' TND';
    }
}
