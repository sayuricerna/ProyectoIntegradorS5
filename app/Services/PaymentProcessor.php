<?php

namespace App\Services;

use App\Contracts\PaymentStrategy;
use App\Models\Order;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PaymentProcessor
{
    protected $paymentStrategy;

    public function setPaymentStrategy(PaymentStrategy $strategy)
    {
        $this->paymentStrategy = $strategy;
    }

    public function process(Order $order, Request $request): bool
    {
        if (!$this->paymentStrategy) {
            throw new InvalidArgumentException("No hay payment strategy set");
        }
        return $this->paymentStrategy->processPayment($order, $request);
    }
}