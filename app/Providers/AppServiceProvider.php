<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\StubGateway;
use App\Services\Payment\PaymentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the payment gateway and payment service into the container.
        $this->app->singleton(PaymentGatewayInterface::class, function () {
            // Use Paystack if keys are configured, otherwise use StubGateway
            $publicKey = \App\Models\Setting::get('paystack_public_key') ?: config('services.paystack.public_key');
            $secretKey = \App\Models\Setting::get('paystack_secret_key') ?: config('services.paystack.secret_key');
            
            if ($publicKey && $secretKey) {
                return new \App\Services\Payment\PaystackGateway();
            }
            
            return new StubGateway();
        });

        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService($app->make(PaymentGatewayInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom middleware aliases.  Because this project
        // does not use the standard Http\Kernel, we bind our role
        // middleware directly via the Route facade in the boot method.
        \Illuminate\Support\Facades\Route::aliasMiddleware('role', \App\Http\Middleware\EnsureRole::class);
    }
}
