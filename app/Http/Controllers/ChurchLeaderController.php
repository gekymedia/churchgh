<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\Request;

class ChurchLeaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|pastor|leader');
    }

    /**
     * Display a listing of church leaders/officers.
     */
    public function index(Request $request)
    {
        $query = Member::with('positions');

        // Filter by position
        if ($request->filled('position')) {
            $query->whereHas('positions', function($q) use ($request) {
                $q->where('name', $request->position);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leaders = $query->whereHas('positions')->with('positions')->latest()->paginate(20)->withQueryString();
        $positions = Position::all();
        
        return view('church-leaders.index', compact('leaders', 'positions'));
    }

    /**
     * Show form to assign positions to a member.
     */
    public function create()
    {
        $members = Member::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'phone', 'email', 'gender']);
        $positions = Position::all();
        return view('church-leaders.create', compact('members', 'positions'));
    }

    /**
     * Assign positions to a member.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'positions' => 'required|array',
            'positions.*' => 'exists:positions,id',
        ]);

        $member = Member::findOrFail($data['member_id']);
        $member->positions()->sync($data['positions']);

        return redirect()->route('church-leaders.index')
            ->with('success', 'Positions assigned successfully.');
    }

    /**
     * Show form to edit member positions.
     */
    public function edit(Member $member)
    {
        $positions = Position::all();
        // Load member with positions
        $member->load('positions');
        return view('church-leaders.edit', compact('member', 'positions'));
    }

    /**
     * Update member positions.
     */
    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'positions' => 'required|array',
            'positions.*' => 'exists:positions,id',
        ]);

        $member->positions()->sync($data['positions']);

        return redirect()->route('church-leaders.index')
            ->with('success', 'Positions updated successfully.');
    }

    /**
     * Show a specific church leader.
     */
    public function show(Member $member)
    {
        $member->load('positions', 'user');
        return view('church-leaders.show', compact('member'));
    }

    /**
     * Remove all positions from a member.
     */
    public function destroy(Member $member)
    {
        $member->positions()->detach();
        return back()->with('success', 'Positions removed successfully.');
    }
}
