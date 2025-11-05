<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\Notifications\Notifier;
use Illuminate\Http\Request;

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
    public function send(Request $request, Notifier $notifier)
    {
        $data = $request->validate([
            'channel'  => 'required|in:sms,whatsapp',
            'lead_id'  => 'nullable|exists:leads,id',
            'broadcast'=> 'nullable|boolean',
            'message'  => 'required|string|max:1000',
        ]);
        $count = 0;
        if ($request->boolean('broadcast')) {
            Lead::whereNotNull('phone')->chunk(100, function ($chunk) use ($notifier, $data, &$count) {
                foreach ($chunk as $lead) {
                    $to = preg_replace('/[^0-9+]/', '', $lead->phone ?? '');
                    if (!$to) {
                        continue;
                    }
                    if ($data['channel'] === 'sms') {
                        $notifier->sms($to, $data['message']);
                    } else {
                        $notifier->whatsapp($to, $data['message']);
                    }
                    $count++;
                }
            });
        } else {
            $lead = Lead::findOrFail($data['lead_id']);
            $to = preg_replace('/[^0-9+]/', '', $lead->phone ?? '');
            if (!$to) {
                return back()->with('error', 'Lead has no phone number');
            }
            if ($data['channel'] === 'sms') {
                $notifier->sms($to, $data['message']);
            } else {
                $notifier->whatsapp($to, $data['message']);
            }
            $count = 1;
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}