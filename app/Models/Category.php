<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function products(){
        return $this->hasMany(Product::class);
    }
    protected static function boot(){
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}
