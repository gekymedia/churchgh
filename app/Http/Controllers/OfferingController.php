<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offering;
use App\Models\Member;

class OfferingController extends Controller
{
    public function index()
    {
        $offerings = Offering::with('member')->latest()->paginate(20);
        $members = Member::orderBy('first_name')->get(['id','first_name','last_name']);
        return view('givings.offerings', compact('offerings','members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:60', // e.g., Sunday, Welfare, Project
            'paid_at' => 'required|date',
            'reference' => 'nullable|string|max:120',
            'notes' => 'nullable|string|max:255',
        ]);
        Offering::create($data);
        return back()->with('success', 'Offering saved.');
    }
}
