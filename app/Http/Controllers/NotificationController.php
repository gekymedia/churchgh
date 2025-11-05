<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Services\Notifications\Notifier;

class NotificationController extends Controller
{
    public function create()
    {
        $members = Member::orderBy('first_name')->get(['id','first_name','last_name','phone']);
        return view('notifications.create', compact('members'));
    }

    public function send(Request $request, Notifier $notifier)
    {
        $data = $request->validate([
            'channel' => 'required|in:sms,whatsapp',
            'member_id' => 'nullable|exists:members,id',
            'broadcast' => 'nullable|boolean',
            'message' => 'required|string|max:1000',
        ]);

        $count = 0;
        if ($request->boolean('broadcast')) {
            Member::whereNotNull('phone')->chunk(100, function($chunk) use ($notifier, $data, &$count) {
                foreach ($chunk as $m) {
                    $to = preg_replace('/[^0-9+]/','', $m->phone ?? '');
                    if (!$to) continue;
                    $data['channel']==='sms' ? $notifier->sms($to, $data['message']) : $notifier->whatsapp($to, $data['message']);
                    $count++;
                }
            });
        } else {
            $member = Member::findOrFail($data['member_id']);
            $to = preg_replace('/[^0-9+]/','', $member->phone ?? '');
            if (!$to) return back()->with('error','Member has no phone number');
            $data['channel']==='sms' ? $notifier->sms($to, $data['message']) : $notifier->whatsapp($to, $data['message']);
            $count = 1;
        }
        return back()->with('success', "Queued {$count} message(s).");
    }
}
