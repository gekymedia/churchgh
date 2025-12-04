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
        $members = Member::orderBy('first_name')->get(['id','first_name','last_name','phone']);
        return view('notifications.create', compact('members'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'channel' => 'required|in:sms,whatsapp',
            'member_id' => 'required_without:broadcast|nullable|exists:members,id',
            'broadcast' => 'nullable|boolean',
            'message' => 'required|string|max:1000',
        ]);

        $channel = $data['channel'];
        $message = $data['message'];
        $count = 0;
        if ($request->boolean('broadcast')) {
            Member::whereNotNull('phone')
                ->orderBy('id')
                ->chunkById(100, function($chunk) use ($channel, $message, &$count) {
                foreach ($chunk as $m) {
                    $to = Phone::formatE164($m->phone);
                    if (!$to) {
                        continue;
                    }
                    SendNotificationMessage::dispatch($channel, $to, $message);
                    $count++;
                }
            });
        } else {
            $member = Member::findOrFail($data['member_id']);
            $to = Phone::formatE164($member->phone);
            if (!$to) {
                return back()->with('error','Member has no phone number');
            }
            SendNotificationMessage::dispatch($channel, $to, $message);
            $count = 1;
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}
