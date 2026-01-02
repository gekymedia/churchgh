<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tithe;
use App\Models\Member;

class TitheController extends Controller
{
    public function index(Request $request)
    {
        $query = Tithe::with('member');

        // Search by member name or reference
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('member', function($memberQuery) use ($search) {
                      $memberQuery->where('first_name', 'like', "%{$search}%")
                                   ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by member
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('paid_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('paid_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        $tithes = $query->latest('paid_at')->paginate(20)->withQueryString();
        $members = Member::orderBy('first_name')->get(['id','first_name','last_name']);
        
        return view('givings.tithes', compact('tithes','members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'reference' => 'nullable|string|max:120',
            'notes' => 'nullable|string|max:255',
        ]);
        Tithe::create($data);
        return back()->with('success', 'Tithe saved.');
    }
}
