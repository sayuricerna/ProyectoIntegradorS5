<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
use HasFactory;

    protected $fillable = [
        'invoice_number',
        'issue_date',
        'due_date',
        'user_id',
        'order_id',
        'client_name',
        'client_email',
        'client_phone',
        'client_address',
        'client_city',
        'client_province',
        'client_country',
        'client_zip',
        'client_reference',
        'payment_method',
        'payment_status',
        'transaction_reference',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'items',
        'pdf_path',
        'notes',
        'terms'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public static function generateInvoiceNumber()
    {
        $prefix = 'FACT-';
        $date = now()->format('Ymd');
        $lastInvoice = self::orderBy('id', 'desc')->first();
        
        $number = $lastInvoice ? str_pad((int)explode('-', $lastInvoice->invoice_number)[2] + 1, 5, '0', STR_PAD_LEFT) 
                               : str_pad(1, 5, '0', STR_PAD_LEFT);
        
        return $prefix . $date . '-' . $number;
    }
}
