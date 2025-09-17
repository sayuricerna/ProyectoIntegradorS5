<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'featured',
        'image',
        'images',
        'category_id',
        'brand_id'
    ];
    public function category(){
        return $this->belongsTo(Category::class, "category_id");
    }
    public function brand(){
        return $this->belongsTo(Brand::class, "brand_id");
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    // Nueva relación: A través de OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }



}
