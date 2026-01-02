<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Service;
use App\Models\Member;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['member','service']);

        // Search by member name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereHas('service', function($q) use ($request) {
                $q->whereDate('starts_at', '>=', $request->date_from);
            });
        }

        if ($request->filled('date_to')) {
            $query->whereHas('service', function($q) use ($request) {
                $q->whereDate('starts_at', '<=', $request->date_to);
            });
        }

        $records = $query->latest()->paginate(20)->withQueryString();
        
        // Get services for filter dropdown
        $services = Service::orderBy('starts_at', 'desc')->get(['id', 'name', 'starts_at']);
        
        return view('attendances.index', compact('records', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:present,absent,online',
            'notes' => 'nullable|string|max:255',
        ]);
        Attendance::updateOrCreate([
            'service_id' => $data['service_id'],
            'member_id' => $data['member_id'],
        ], $data);

        return back()->with('success', 'Attendance recorded.');
    }
}
