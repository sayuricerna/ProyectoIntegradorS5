<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    // Los campos que son específicos para cada variante.
    protected $fillable = [
        'product_id',
        'sku',
        'regular_price',
        'sale_price',
        'on_sale',
        'quantity',
        'stock_status',
        'color', // Atributo para la variante de color
        'size', // Atributo para la variante de talla
    ];

    /**
     * Define la relación inversa de uno a uno.
     * Una variante pertenece a un solo producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
