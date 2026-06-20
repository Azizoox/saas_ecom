<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'shop_id',
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Automatically generate slug when creating/updating
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            // Regenerate slug if name has changed
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationship with Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Relationship with parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship with child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for root categories (no parent)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    // Get all ancestors
    public function ancestors()
    {
        $ancestors = collect();
        $category = $this;

        while ($category->parent) {
            $ancestors->push($category->parent);
            $category = $category->parent;
        }

        return $ancestors->reverse();
    }

    // Get all descendants
    public function descendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants());
        }

        return $descendants;
    }

    // Check if category has children
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    // Get breadcrumb trail
    public function breadcrumb()
    {
        return $this->ancestors()->push($this);
    }

    // Get full category path name
    public function getFullNameAttribute()
    {
        $names = $this->ancestors->pluck('name')->push($this->name);
        return $names->implode(' > ');
    }
}