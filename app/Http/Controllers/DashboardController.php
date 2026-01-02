<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Service;
use App\Models\Attendance;
use App\Models\Tithe;
use App\Models\Offering;
use App\Models\Event;
use App\Models\Followup;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function index()
    {
        // total members
        $memberCount = Member::count();
        // new members this month
        $newMembers = Member::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        // services count
        $serviceCount = Service::count();
        // upcoming events count
        $eventCount = Event::where('starts_at', '>=', now())->count();
        // attendance records count
        $attendanceCount = Attendance::count();
        // sum of tithes and offerings via legacy tables
        $titheSum = Tithe::sum('amount');
        $offeringSum = Offering::sum('amount');
        // sum of online givings this month (anonymous and named)
        $givingSum = \App\Models\Giving::whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');
        // recent givings (limit 5)
        $recentGivings = \App\Models\Giving::with('user')
            ->latest()
            ->take(5)
            ->get();
        // upcoming events list (next 30 days)
        $upcomingEvents = Event::where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->take(5)
            ->get();
        // today’s quote/devotional
        $todaysQuote = \App\Models\Quote::where('delivery_date', now()->toDateString())->first();
        // pending follow‑ups count
        $pendingFollowups = Followup::whereNull('completed_at')->count();
        // total leads
        $leadCount = Lead::count();

        return view('dashboard.index', [
            'members'          => $memberCount,
            'new_members'      => $newMembers,
            'services'         => $serviceCount,
            'events'           => $eventCount,
            'attendances'      => $attendanceCount,
            'tithes'           => $titheSum,
            'offerings'        => $offeringSum,
            'givings'          => $givingSum,
            'recent_givings'   => $recentGivings,
            'upcoming_events'  => $upcomingEvents,
            'todays_quote'     => $todaysQuote,
            'pending_followups'=> $pendingFollowups,
            'lead_count'       => $leadCount,
        ]);
    }
}
