<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public function products(){
        return $this->hasMany(Product::class);
    }
    // Observer para el link slug
    // Este método se ejecuta antes de crear o actualizar un modelo
    // y asegura que el slug se genere a partir del nombre de la marca
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }
}

