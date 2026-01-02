<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Payment\PaymentService;
use App\Models\Giving;

/**
 * Class GivingController
 *
 * Handles the online giving workflow for members. Presents a form to
 * collect the type of giving, amount, optional note and anonymity
 * preference, then delegates payment processing to the PaymentService.
 */
class GivingController extends Controller
{
    public function __construct(protected PaymentService $payments)
    {
        // ensure user is authenticated for giving
        $this->middleware('auth');
    }

    /**
     * Display the giving form.
     */
    public function create()
    {
        return view('giving.create');
    }

    /**
     * Process the giving submission.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type'  => 'required|string|max:50',
            'amount'=> 'required|numeric|min:0.01',
            'note'  => 'nullable|string|max:255',
            'anonymous' => 'sometimes|boolean',
        ]);
        $user = Auth::user();
        $isAnonymous = !($request->boolean('anonymous') === true);
        $giving = $this->payments->process(
            $user,
            $data['type'],
            (float) $data['amount'],
            $isAnonymous,
            $data['note'] ?? null,
        );
        return redirect()->route('member.dashboard')->with('success', 'Thank you for your giving! Reference: '.$giving->reference);
    }

    /**
     * Show all givings to admin.
     */
    public function index()
    {
        // Only admin/pastor should view all givings; guard via middleware
        $givings = Giving::with(['user','member'])->latest()->paginate(30);
        return view('giving.index', compact('givings'));
    }
}