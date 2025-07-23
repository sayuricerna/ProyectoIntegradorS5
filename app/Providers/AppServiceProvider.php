<?php

namespace App\Providers;
use App\Services\PaymentProcessor;
use App\Contracts\PaymentStrategy;
use App\Services\Payments\BankPaymentStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(PaymentProcessor::class, function ($app) {
            return new PaymentProcessor();
        });
        // estrategia por defecto
        $this->app->bind(PaymentStrategy::class, BankPaymentStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
