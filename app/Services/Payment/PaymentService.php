<?php

namespace App\Services\Payment;

use App\Models\Giving;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Class PaymentService
 *
 * Coordinates the charging of a user via a payment gateway and the
 * persistence of the resulting Giving record. By centralising this
 * logic we can easily swap payment gateways or adjust recording logic.
 */
class PaymentService
{
    public function __construct(protected PaymentGatewayInterface $gateway)
    {
    }

    /**
     * Process a giving transaction and record it in the database.
     *
     * @param User|null $user The user making the payment
     * @param string    $type The type of giving (tithe, offering, seed, donation)
     * @param float     $amount The amount to charge
     * @param bool      $isAnonymous Whether the donor wants to remain anonymous
     * @param string|null $note Optional note or message
     * @param array     $payload Additional payload for the gateway
     *
     * @return Giving
     */
    public function process(?User $user, string $type, float $amount, bool $isAnonymous = true, ?string $note = null, array $payload = []): Giving
    {
        $result = $this->gateway->charge($user, $amount, $payload);
        if (!($result['success'] ?? false)) {
            throw new \RuntimeException($result['error'] ?? 'Payment failed');
        }
        $giving = new Giving();
        $giving->user()->associate($user);
        // If the user has a member profile, associate it with the giving
        if ($user && $user->member) {
            $giving->member()->associate($user->member);
        }
        $giving->type         = $type;
        $giving->amount       = $amount;
        $giving->is_anonymous = $isAnonymous;
        $giving->note         = $note;
        $giving->reference    = $result['reference'] ?? null;
        $giving->method       = $result['method'] ?? null;
        $giving->paid_at      = Carbon::now();
        $giving->save();
        return $giving;
    }
}