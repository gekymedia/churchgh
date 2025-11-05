<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

/**
 * Class LeadController
 *
 * Provides CRUD functionality for managing leads captured during outreach or
 * evangelistic activities. Leads enable the church to stay connected with
 * prospective members and share upcoming events or inspirational content.
 */
class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index()
    {
        $leads = Lead::latest()->paginate(15);
        return view('leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
        return view('leads.create');
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:150',
            'phone' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:150',
            'notes' => 'nullable|string|max:1000',
        ]);
        Lead::create($data);
        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:150',
            'phone' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:150',
            'notes' => 'nullable|string|max:1000',
        ]);
        $lead->update($data);
        return redirect()->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead deleted.');
    }
}