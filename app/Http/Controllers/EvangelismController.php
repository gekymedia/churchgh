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
        $leads = Lead::orderBy('name')->get(['id','name','phone','email']);
        return view('evangelism.create', compact('leads'));
    }

    /**
     * Handle sending of evangelism messages.
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'channel'  => 'required|in:sms,whatsapp,telegram,gekychat,email',
            'lead_ids' => 'required_without:broadcast|nullable|array',
            'lead_ids.*' => 'exists:leads,id',
            'broadcast'=> 'nullable|boolean',
            'message'  => 'required|string|max:1000',
        ]);
        $channel = $data['channel'];
        $message = $data['message'];
        $count = 0;
        
        // Determine what field to use based on channel
        $needsPhone = in_array($channel, ['sms', 'whatsapp', 'telegram', 'gekychat']);
        $needsEmail = $channel === 'email';
        $subject = $request->input('subject');
        
        if ($request->boolean('broadcast')) {
            // Broadcast to all leads
            $query = Lead::query();
            
            if ($needsPhone) {
                $query->whereNotNull('phone');
            } elseif ($needsEmail) {
                $query->whereNotNull('email');
            }
            
            $query->orderBy('id')
                ->chunkById(100, function ($chunk) use ($channel, $message, &$count, $needsPhone, $needsEmail, $subject) {
                    foreach ($chunk as $lead) {
                        $to = null;
                        if ($needsPhone) {
                            $to = Phone::formatE164($lead->phone);
                        } elseif ($needsEmail) {
                            $to = $lead->email;
                        }
                        
                        if (!$to) {
                            continue;
                        }
                        SendNotificationMessage::dispatch($channel, $to, $message, $subject);
                        $count++;
                    }
                });
        } else {
            // Send to selected leads
            $leadIds = $data['lead_ids'] ?? [];
            
            if (empty($leadIds)) {
                return back()->with('error', 'Please select at least one lead or enable broadcast to all.');
            }
            
            $leads = Lead::whereIn('id', $leadIds)->get();
            
            foreach ($leads as $lead) {
                $to = null;
                if ($needsPhone) {
                    $to = Phone::formatE164($lead->phone);
                    if (!$to) {
                        continue; // Skip leads without phone for phone-based channels
                    }
                } elseif ($needsEmail) {
                    $to = $lead->email;
                    if (!$to) {
                        continue; // Skip leads without email for email channel
                    }
                }
                
                SendNotificationMessage::dispatch($channel, $to, $message, $subject);
                $count++;
            }
            
            if ($count === 0) {
                $errorMsg = $needsPhone 
                    ? 'None of the selected leads have phone numbers.' 
                    : 'None of the selected leads have email addresses.';
                return back()->with('error', $errorMsg);
            }
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}