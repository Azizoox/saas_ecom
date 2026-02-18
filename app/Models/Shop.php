<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'keywords',
        'description',
        'subdomain',
        'custom_domain',
        'logo',
        'favicon',
        'company_name',
        'tax_id',
        'contact_email',
        'contact_phone',
        'street',
        'city',
        'state',
        'postal_code',
        'latitude',
        'longitude',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function settings()
    {
        return $this->hasOne(ShopSetting::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function components()
    {
        return $this->hasMany(ShopComponent::class)->orderBy('order');
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('order');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
