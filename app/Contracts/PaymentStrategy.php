<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentStrategy
{
    /**
     * Procesa el pago para una orden dada parte de patrones GoF
     *
     * @param Order $order La orden a procesar.
     * @param Request $request La petición HTTP con los datos del pago.
     * @return bool True si el pago fue exitoso, false en caso contrario.
     */
    public function processPayment(Order $order, Request $request): bool;
}