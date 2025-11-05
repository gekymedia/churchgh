<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tithe;
use App\Models\Member;

class TitheController extends Controller
{
    public function index()
    {
        $tithes = Tithe::with('member')->latest()->paginate(20);
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
