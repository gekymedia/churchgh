<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(15);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:150',
            'gender' => 'nullable|in:male,female',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'membership_status' => 'nullable|string|max:50',
        ]);

        Member::create($data);
        return redirect()->route('members.index')->with('success', 'Member created.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:150',
            'gender' => 'nullable|in:male,female',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'membership_status' => 'nullable|string|max:50',
        ]);

        $member->update($data);
        return redirect()->route('members.index')->with('success', 'Member updated.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('success', 'Member deleted.');
    }
}
