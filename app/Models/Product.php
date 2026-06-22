<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image'];

    protected $appends = ['image_url'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
