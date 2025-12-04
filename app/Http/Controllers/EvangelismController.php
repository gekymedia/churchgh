<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Jobs\SendNotificationMessage;
use App\Support\Phone;

/**
 * Class EvangelismController
 *
 * This controller handles sending evangelism messages to leads. It uses the
 * existing Notifier service to queue SMS or WhatsApp messages. Messages may
 * be sent individually to a selected lead or broadcast to all stored leads.
 */
class EvangelismController extends Controller
{
    /**
     * Show the evangelism form to send a message to one or more leads.
     */
    public function create()
    {
        $leads = Lead::orderBy('name')->get(['id','name','phone']);
        return view('evangelism.create', compact('leads'));
    }

    /**
     * Handle sending of evangelism messages.
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'channel'  => 'required|in:sms,whatsapp',
            'lead_id'  => 'required_without:broadcast|nullable|exists:leads,id',
            'broadcast'=> 'nullable|boolean',
            'message'  => 'required|string|max:1000',
        ]);
        $channel = $data['channel'];
        $message = $data['message'];
        $count = 0;
        if ($request->boolean('broadcast')) {
            Lead::whereNotNull('phone')
                ->orderBy('id')
                ->chunkById(100, function ($chunk) use ($channel, $message, &$count) {
                    foreach ($chunk as $lead) {
                        $to = Phone::formatE164($lead->phone);
                        if (!$to) {
                            continue;
                        }
                        SendNotificationMessage::dispatch($channel, $to, $message);
                        $count++;
                    }
                });
        } else {
            $lead = Lead::findOrFail($data['lead_id']);
            $to = Phone::formatE164($lead->phone);
            if (!$to) {
                return back()->with('error', 'Lead has no phone number');
            }
            SendNotificationMessage::dispatch($channel, $to, $message);
            $count = 1;
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}