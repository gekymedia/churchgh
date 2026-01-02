<?php

namespace App\Services\Payment;

use App\Models\User;

/**
 * Class StubGateway
 *
 * A stub payment gateway that simulates successful transactions without
 * contacting any external service. Useful during development or when no
 * real payment gateway is configured. Generates a pseudo‑random reference
 * for each charge and marks the payment method as 'stub'.
 */
class StubGateway implements PaymentGatewayInterface
{
    public function charge(?User $user, float $amount, array $payload = []): array
    {
        // In a real gateway, here you would contact the external API.
        // We'll simply return a success response with a random reference.
        $reference = 'STUB-' . strtoupper(bin2hex(random_bytes(6)));
        return [
            'success'   => true,
            'reference' => $reference,
            'method'    => 'stub',
        ];
    }
}