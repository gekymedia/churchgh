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
        return view('dashboard.index', [
            'members'          => Member::count(),
            'services'         => Service::count(),
            'events'           => Event::count(),
            'attendances'      => Attendance::count(),
            'tithes'           => Tithe::sum('amount'),
            'offerings'        => Offering::sum('amount'),
            // New metrics
            'pending_followups'=> Followup::whereNull('completed_at')->count(),
            'lead_count'       => Lead::count(),
        ]);
    }
}
