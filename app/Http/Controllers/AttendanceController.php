<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Service;
use App\Models\Member;

class AttendanceController extends Controller
{
    public function index()
    {
        $records = Attendance::with(['member','service'])->latest()->paginate(20);
        return view('attendances.index', compact('records'));
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
