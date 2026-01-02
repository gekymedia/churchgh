<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventRegistration;

/**
 * Class EventRegistrationController
 *
 * Allows members to register for events. A registration is created linking
 * the authenticated user to the selected event. Duplicate registrations
 * are prevented via a unique constraint on the event_registrations table.
 */
class EventRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Register the authenticated user for the given event.
     */
    public function store(Event $event, Request $request)
    {
        $user = Auth::user();
        $registration = EventRegistration::firstOrCreate(
            [
                'event_id' => $event->id,
                'user_id'  => $user->id,
            ],
            [
                'registered_at' => now(),
            ]
        );
        return back()->with('success', 'You have been registered for this event.');
    }
}