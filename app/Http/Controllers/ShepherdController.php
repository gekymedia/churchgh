<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShepherdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Protect assign routes
        $this->middleware('role:admin|pastor|leader')->only(['assign', 'showAssignForm']);
    }

    /**
     * Display shepherd's flock (assigned members).
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is a shepherd
        if (!$user->isShepherd()) {
            abort(403, 'You are not authorized to view this page.');
        }

        $flock = $user->flock()->with(['attendances', 'tithes', 'offerings'])->get();
        
        return view('shepherd.flock', compact('flock'));
    }

    /**
     * Assign members to a shepherd (admin only).
     */
    public function assign(Request $request)
    {
        $data = $request->validate([
            'shepherd_id' => 'required|exists:users,id',
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
        ]);

        $shepherd = User::findOrFail($data['shepherd_id']);
        
        // Verify shepherd has position
        if (!$shepherd->isShepherd()) {
            return back()->with('error', 'Selected user is not a shepherd.');
        }

        $shepherd->flock()->sync($data['member_ids']);

        return back()->with('success', 'Members assigned to shepherd successfully.');
    }

    /**
     * Show form to assign members to shepherds.
     */
    public function showAssignForm()
    {
        // Get all users who are shepherds (have member with shepherd position)
        $shepherds = User::whereHas('member', function($q) {
            $q->whereHas('positions', function($posQuery) {
                $posQuery->where('name', 'shepherd');
            });
        })->with('member')->get(['id', 'name', 'email']);
        
        // Get all members who are not already assigned to a shepherd (optional - or show all)
        $members = Member::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'phone', 'email']);
        
        return view('shepherd.assign', compact('shepherds', 'members'));
    }
}
