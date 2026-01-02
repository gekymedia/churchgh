<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\StubGateway;
use App\Services\Payment\PaymentService;

/**
 * Class PaymentServiceProvider
 *
 * Registers the payment gateway and payment service into the service
 * container. By using a service provider we can easily swap the
 * gateway implementation via configuration or environment settings.
 */
class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind the payment gateway interface to a concrete implementation.
        // In a real application you might switch on config values here.
        $this->app->singleton(PaymentGatewayInterface::class, function () {
            return new StubGateway();
        });

        // Bind the PaymentService which will receive the gateway via
        // automatic dependency injection.
        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService($app->make(PaymentGatewayInterface::class));
        });
    }
}