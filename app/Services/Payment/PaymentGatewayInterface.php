<?php

namespace App\Services\Payment;

use App\Models\User;

/**
 * Interface PaymentGatewayInterface
 *
 * Defines a minimal contract for payment gateways used to process
 * financial transactions. Implementations can wrap real gateways (e.g.,
 * Paystack, Hubtel, Stripe) or provide stubbed functionality during
 * development.
 */
interface PaymentGatewayInterface
{
    /**
     * Charge the given user a specified amount.
     *
     * @param User|null $user  The user initiating the payment (optional)
     * @param float     $amount The amount to charge
     * @param array     $payload Additional data (e.g., currency, metadata)
     *
     * @return array{success: bool, reference: string, method: string|null, error?: string}
     */
    public function charge(?User $user, float $amount, array $payload = []): array;
}