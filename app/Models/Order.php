<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'user_id',
    //     'order_status',
    //     'payment_method',
    //     'payment_status',
    //     'subtotal',
    //     'tax',
    // ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
