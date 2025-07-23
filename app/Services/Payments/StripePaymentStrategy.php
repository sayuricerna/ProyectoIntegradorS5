<?php

namespace App\Services\Payments;

use App\Contracts\PaymentStrategy;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\StripeClient; 
use Exception; 
class StripePaymentStrategy implements PaymentStrategy
{
    protected $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }
    public function processPayment(Order $order, Request $request): bool
    {
            try {
        $paymentMethodId = $request->input('payment_method_id');
        if (empty($paymentMethodId)) {
            throw new Exception("Payment method ID is missing.");
        }
        
        $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => round($order->total * 100),
            'currency' => 'usd',
            'payment_method' => $paymentMethodId,
            'confirm' => true,
            'return_url' => route('cart.order.confirmation', ['order_id' => $order->id]),
            'description' => 'Payment for Order #' . $order->id,
            'metadata' => ['order_id' => $order->id, 'user_id' => $order->user_id],
            'receipt_email' => $order->user->email,
        ]);

        $status = 'failed';
        if ($paymentIntent->status == 'succeeded') {
            $status = 'approved';
        } elseif ($paymentIntent->status == 'requires_action') {
            $status = 'pending';
            \Session::put('stripe_client_secret', $paymentIntent->client_secret);
        }

        $transaction = new Transaction();
        $transaction->user_id = $order->user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = 'stripe';
        $transaction->status = $status;
        $transaction->transaction_id = $paymentIntent->id;
        $transaction->save();

        return $paymentIntent->status === 'succeeded';

    } catch (Exception $e) {
        \Log::error("Error procesando Stripe para la orden {$order->id}: " . $e->getMessage());
        \Session::flash('error', $e->getMessage());
        return false;
    }
        // try {
        //     $paymentMethodId = $request->input('payment_method_id');
        //     if (empty($paymentMethodId)) {
        //         throw new Exception("Payment method ID is missing.");
        //     }
            
        //     $paymentIntent = $this->stripe->paymentIntents->create([
        //         'amount' => round($order->total * 100), 
        //         'currency' => 'usd',
        //         'payment_method' => $paymentMethodId,
        //         'confirm' => true,
        //         'return_url' => route('cart.order.confirmation', ['order_id' => $order->id]),
        //         'description' => 'Payment for Order #' . $order->id,
        //         'metadata' => ['order_id' => $order->id, 'user_id' => $order->user_id],
        //         'receipt_email' => $order->user->email,
        //         'off_session' => false, 
        //     ]);

        //     if ($paymentIntent->status == 'succeeded') {
        //         $status = 'approved'; 
        //     } elseif ($paymentIntent->status == 'requires_action') {
        //         $status = 'pending';
        //         \Session::put('stripe_client_secret', $paymentIntent->client_secret);
        //     } else {
        //         $status = 'failed'; 
        //     }
        //     $transaction = new Transaction();
        //     $transaction->user_id = $order->user_id;
        //     $transaction->order_id = $order->id;
        //     $transaction->mode = 'stripe';
        //     $transaction->status = $status;
        //     $transaction->transaction_id = $paymentIntent->id;
        //     $transaction->save();
        //     return $paymentIntent->status === 'succeeded';

        // } catch (\Stripe\Exception\CardException $e) {
        //     \Log::error("Card error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', $e->getMessage());
        //     return false;
        // } catch (\Stripe\Exception\RateLimitException $e) {
        //     \Log::error("Rate limit error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'Too many requests to Stripe. Please try again later.');
        //     return false;
        // } catch (\Stripe\Exception\InvalidRequestException $e) {
        //     // Parámetros inválidos
        //     \Log::error("Invalid request error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'Invalid Stripe request. Please check your data.');
        //     return false;
        // } catch (\Stripe\Exception\AuthenticationException $e) {
        //     \Log::error("Authentication error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'Stripe authentication failed. Check API keys.');
        //     return false;
        // } catch (\Stripe\Exception\ApiConnectionException $e) {
        //     \Log::error("API connection error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'Could not connect to Stripe. Check your network connection.');
        //     return false;
        // } catch (\Stripe\Exception\ApiErrorException $e) {
        //     \Log::error("Stripe API error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'Stripe API error: ' . $e->getMessage());
        //     return false;
        // } catch (Exception $e) {
        //     \Log::error("General error processing Stripe payment for order {$order->id}: " . $e->getMessage());
        //     \Session::flash('error', 'An unexpected error occurred: ' . $e->getMessage());
        //     return false;
        // }
    }
}