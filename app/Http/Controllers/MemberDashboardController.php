<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Quote;
use App\Models\Event;

/**
 * Class MemberDashboardController
 *
 * Provides an overview page for logged‑in members. Displays today's
 * devotional quote, upcoming events, and the member's recent giving
 * history. Additional sections can be added as needed.
 */
class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user?->member;
        // Today's quote (if any)
        $todayQuote = Quote::where('delivery_date', Carbon::today()->toDateString())->first();
        // Upcoming events in next 30 days
        $events = Event::where('starts_at', '>=', Carbon::now())
            ->where('starts_at', '<=', Carbon::now()->addDays(30))
            ->orderBy('starts_at')
            ->get();
        // Member giving history (latest 5 non‑anonymous givings)
        $givings = $user?->givings()
            ->where('is_anonymous', false)
            ->latest()
            ->take(5)
            ->get();
        return view('member.dashboard', [
            'quote'   => $todayQuote,
            'events'  => $events,
            'givings' => $givings,
            'member'  => $member,
        ]);
    }
}