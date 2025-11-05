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
    public function index()
    {
        $followups = Followup::with('member')
            ->orderBy('followup_date')
            ->paginate(20);
        return view('followups.index', compact('followups'));
    }

    /**
     * Show the form for creating a new follow‑up.
     */
    public function create()
    {
        $members = Member::orderBy('first_name')->get();
        return view('followups.create', compact('members'));
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
        return view('followups.edit', compact('followup', 'members'));
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
        $followup->update(['completed_at' => now()]);
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