<?php

namespace App\Services\Payments;

use App\Contracts\PaymentStrategy;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BankPaymentStrategy implements PaymentStrategy
{
    public function processPayment(Order $order, Request $request): bool
    {
        try {
            $transaction = new Transaction();
            $transaction->user_id = $order->user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = 'tranference';
            $transaction->status = 'pending'; // confirmacion manual
            $transaction->save();
            return true;
        } catch (\Exception $e) {
            \Log::error("Error al procesar pago por transferencia para la orden {$order->id}: " . $e->getMessage());
            return false;
        }
    }
}