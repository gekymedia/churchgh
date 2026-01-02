<?php

namespace App\Http\Controllers;

use App\Models\Giving;
use App\Services\Payment\PaystackGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected PaystackGateway $gateway;

    public function __construct()
    {
        $this->middleware('auth');
        $this->gateway = new PaystackGateway();
    }

    /**
     * Initialize a Paystack payment.
     */
    public function initialize(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|in:tithe,offering,building,missions,special',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
            'is_anonymous' => 'sometimes|boolean',
        ]);

        $user = Auth::user();
        $amount = (float) $data['amount'];

        $result = $this->gateway->charge($user, $amount, [
            'type' => $data['type'],
            'callback_url' => route('payment.callback'),
        ]);

        if (!$result['success']) {
            return back()->with('error', $result['error'] ?? 'Payment initialization failed.');
        }

        // Store pending giving in session
        session([
            'pending_giving' => [
                'type' => $data['type'],
                'amount' => $amount,
                'note' => $data['note'] ?? null,
                'is_anonymous' => $request->boolean('is_anonymous', true),
                'reference' => $result['reference'],
            ]
        ]);

        // Redirect to Paystack payment page
        if (isset($result['authorization_url']) && !empty($result['authorization_url'])) {
            return redirect($result['authorization_url']);
        }

        return back()->with('error', 'Failed to initialize payment. Please check your Paystack configuration in Settings.');
    }

    /**
     * Handle Paystack callback.
     */
    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Payment reference not found.');
        }

        // Verify transaction with Paystack
        $verification = $this->gateway->verify($reference);

        if (!$verification['success'] || !$verification['status']) {
            return redirect()->route('member.dashboard')
                ->with('error', $verification['error'] ?? 'Payment verification failed.');
        }

        // Get pending giving from session
        $pendingGiving = session('pending_giving');
        
        if (!$pendingGiving || $pendingGiving['reference'] !== $reference) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Payment session expired. Please try again.');
        }

        // Create giving record
        $user = Auth::user();
        $giving = Giving::create([
            'user_id' => $user->id,
            'member_id' => $user->member_id,
            'type' => $pendingGiving['type'],
            'amount' => $verification['amount'],
            'is_anonymous' => $pendingGiving['is_anonymous'],
            'note' => $pendingGiving['note'],
            'reference' => $reference,
            'method' => 'paystack',
            'paid_at' => $verification['paid_at'] ?? now(),
        ]);

        // Clear session
        session()->forget('pending_giving');

        return redirect()->route('member.dashboard')
            ->with('success', 'Payment successful! Thank you for your giving. Reference: ' . $reference);
    }
}
