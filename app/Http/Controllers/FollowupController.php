<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * Class FollowupController
 *
 * Handles CRUD operations for follow‑up tasks. Follow‑ups help church
 * leadership and assimilation teams ensure every member receives the
 * appropriate care and engagement after key interactions. This controller
 * provides listing, creation, editing, completion and deletion of follow‑up
 * records.
 */
class FollowupController extends Controller
{
    /**
     * Display a listing of follow‑ups.
     */
    public function index(Request $request)
    {
        $query = Followup::with(['member','assignedUser']);

        // Search by member name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhere('note', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by assigned user
        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', $request->assigned_user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('followup_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('followup_date', '<=', $request->date_to);
        }

        $followups = $query->orderBy('followup_date')->paginate(20)->withQueryString();
        
        // Get users for filter dropdown
        $users = \App\Models\User::whereIn('role', ['admin','pastor','leader'])->orderBy('name')->get();
        
        return view('followups.index', compact('followups', 'users'));
    }

    /**
     * Show the form for creating a new follow‑up.
     */
    public function create()
    {
        $members = Member::orderBy('first_name')->get();
        // load users for assignment (leaders/pastors/admin)
        $users = \App\Models\User::whereIn('role', ['admin','pastor','leader'])->orderBy('name')->get();
        return view('followups.create', compact('members','users'));
    }

    /**
     * Store a newly created follow‑up in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id'     => 'required|exists:members,id',
            'followup_date' => 'required|date',
            'note'          => 'nullable|string|max:1000',
            'category'      => 'nullable|string|max:100',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status'        => 'nullable|string|max:50',
        ]);
        Followup::create($data);
        return redirect()->route('followups.index')
            ->with('success', 'Follow‑up created successfully.');
    }

    /**
     * Show the form for editing the specified follow‑up.
     */
    public function edit(Followup $followup)
    {
        $members = Member::orderBy('first_name')->get();
        $users   = \App\Models\User::whereIn('role', ['admin','pastor','leader'])->orderBy('name')->get();
        return view('followups.edit', compact('followup', 'members','users'));
    }

    /**
     * Update the specified follow‑up in storage.
     */
    public function update(Request $request, Followup $followup)
    {
        $data = $request->validate([
            'member_id'     => 'required|exists:members,id',
            'followup_date' => 'required|date',
            'note'          => 'nullable|string|max:1000',
            'category'      => 'nullable|string|max:100',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status'        => 'nullable|string|max:50',
        ]);
        $followup->update($data);
        return redirect()->route('followups.index')
            ->with('success', 'Follow‑up updated successfully.');
    }

    /**
     * Mark the follow‑up as completed.
     */
    public function complete(Followup $followup)
    {
        $followup->update([
            'completed_at' => now(),
            'status'       => 'closed',
        ]);
        return redirect()->route('followups.index')
            ->with('success', 'Follow‑up marked completed.');
    }

    /**
     * Remove the specified follow‑up from storage.
     */
    public function destroy(Followup $followup)
    {
        $followup->delete();
        return back()->with('success', 'Follow‑up deleted.');
    }
}