<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SettingsController
 *
 * Allows authenticated users to update their notification preferences and
 * contact information. Members can toggle whether they receive emails for
 * daily quotes and event reminders.
 */
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the settings form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    /**
     * Update the user's settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'receive_quote_email'          => 'sometimes|boolean',
            'receive_event_reminder_email' => 'sometimes|boolean',
            'phone' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:150',
        ]);
        $user = Auth::user();
        $user->fill($data);
        $user->save();
        return back()->with('success', 'Settings updated successfully.');
    }
}