<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Jobs\SendNotificationMessage;
use App\Support\Phone;

class NotificationController extends Controller
{
    public function create()
    {
        $members = Member::orderBy('first_name')->get(['id','first_name','last_name','phone','email']);
        return view('notifications.create', compact('members'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'channel' => 'required|in:sms,whatsapp,telegram,gekychat,email',
            'member_id' => 'required_without:broadcast|nullable|exists:members,id',
            'broadcast' => 'nullable|boolean',
            'message' => 'required|string|max:1000',
        ]);

        $channel = $data['channel'];
        $message = $data['message'];
        $count = 0;
        
        // Determine what field to use based on channel
        $needsPhone = in_array($channel, ['sms', 'whatsapp', 'telegram', 'gekychat']);
        $needsEmail = $channel === 'email';
        
        if ($request->boolean('broadcast')) {
            $query = Member::query();
            
            if ($needsPhone) {
                $query->whereNotNull('phone');
            } elseif ($needsEmail) {
                $query->whereNotNull('email');
            }
            
            $query->orderBy('id')
                ->chunkById(100, function($chunk) use ($channel, $message, &$count, $needsPhone, $needsEmail) {
                foreach ($chunk as $m) {
                    $to = null;
                    if ($needsPhone) {
                        $to = Phone::formatE164($m->phone);
                    } elseif ($needsEmail) {
                        $to = $m->email;
                    }
                    
                    if (!$to) {
                        continue;
                    }
                    $subject = $request->input('subject');
                    SendNotificationMessage::dispatch($channel, $to, $message, $subject);
                    $count++;
                }
            });
        } else {
            $member = Member::findOrFail($data['member_id']);
            
            if ($needsPhone) {
                $to = Phone::formatE164($member->phone);
                if (!$to) {
                    return back()->with('error','Member has no phone number');
                }
            } elseif ($needsEmail) {
                $to = $member->email;
                if (!$to) {
                    return back()->with('error','Member has no email address');
                }
            }
            
            $subject = $request->input('subject');
            SendNotificationMessage::dispatch($channel, $to, $message, $subject);
            $count = 1;
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}
