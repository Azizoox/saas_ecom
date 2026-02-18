<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        // Display settings
        'currency',
        'language',
        'timezone',
        'theme',
        'primary_color',
        'display_mode',
        'date_format',
        // Payment settings
        'bank_name',
        'bank_account',
        'account_holder',
        'payment_cod',
        'payment_bank_transfer',
        'payment_card',
        'payment_status',
        // Social media
        'facebook_url',
        'instagram_url',
        'tiktok_url',
        'whatsapp_number',
        'twitter_url',
        'youtube_url',
        // Legacy
        'logo',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
