<?php

namespace App\Services\Payment;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class PaystackGateway
 *
 * Paystack payment gateway implementation for processing payments.
 */
class PaystackGateway implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        // Try to get from database settings first, then fallback to config
        $this->secretKey = \App\Models\Setting::get('paystack_secret_key') ?: config('services.paystack.secret_key', '');
        $this->publicKey = \App\Models\Setting::get('paystack_public_key') ?: config('services.paystack.public_key', '');
    }

    public function charge(?User $user, float $amount, array $payload = []): array
    {
        // For Paystack, we initialize a transaction and return the authorization URL
        // The actual charge happens after the user completes payment on Paystack
        
        $reference = 'CHURCH-' . strtoupper(uniqid());
        $amountInKobo = (int)($amount * 100); // Convert to kobo (Paystack uses smallest currency unit)
        
        $metadata = [
            'user_id' => $user?->id,
            'member_id' => $user?->member_id,
            'type' => $payload['type'] ?? 'offering',
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transaction/initialize', [
                'email' => $user?->email ?? $payload['email'] ?? 'member@churchgh.com',
                'amount' => $amountInKobo,
                'reference' => $reference,
                'callback_url' => $payload['callback_url'] ?? route('payment.callback'),
                'metadata' => $metadata,
            ]);

            $responseData = $response->json();
            
            if ($response->successful() && ($responseData['status'] ?? false)) {
                $data = $responseData['data'] ?? [];
                $authorizationUrl = $data['authorization_url'] ?? '';
                
                if (empty($authorizationUrl)) {
                    Log::error('Paystack authorization URL missing', [
                        'response' => $responseData,
                    ]);
                    return [
                        'success' => false,
                        'error' => 'Payment gateway did not return authorization URL',
                        'reference' => $reference,
                        'method' => 'paystack',
                    ];
                }
                
                return [
                    'success' => true,
                    'reference' => $reference,
                    'method' => 'paystack',
                    'authorization_url' => $authorizationUrl,
                ];
            }

            Log::error('Paystack initialization failed', [
                'response' => $response->json(),
                'user' => $user?->id,
                'amount' => $amount,
            ]);

            return [
                'success' => false,
                'error' => $response->json('message', 'Payment initialization failed'),
                'reference' => $reference,
                'method' => 'paystack',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack gateway error', [
                'error' => $e->getMessage(),
                'user' => $user?->id,
                'amount' => $amount,
            ]);

            return [
                'success' => false,
                'error' => 'Payment gateway error: ' . $e->getMessage(),
                'reference' => $reference,
                'method' => 'paystack',
            ];
        }
    }

    /**
     * Verify a Paystack transaction.
     */
    public function verify(string $reference): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
            ])->get($this->baseUrl . '/transaction/verify/' . $reference);

            if ($response->successful() && $response->json('status')) {
                $data = $response->json('data');
                return [
                    'success' => true,
                    'status' => $data['status'] === 'success',
                    'amount' => $data['amount'] / 100, // Convert from kobo
                    'reference' => $data['reference'],
                    'gateway_reference' => $data['reference'],
                    'paid_at' => $data['paid_at'] ?? now(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Transaction verification failed'),
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification error', [
                'error' => $e->getMessage(),
                'reference' => $reference,
            ]);

            return [
                'success' => false,
                'error' => 'Verification error: ' . $e->getMessage(),
            ];
        }
    }
}

