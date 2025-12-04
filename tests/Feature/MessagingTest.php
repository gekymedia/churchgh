<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendNotificationMessage;
use App\Models\Member;
use App\Models\Lead;

uses(RefreshDatabase::class);

it('queues a direct member notification', function () {
    Bus::fake();

    $member = Member::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '0201234567',
    ]);

    $response = post(route('notifications.send'), [
        'channel' => 'sms',
        'member_id' => $member->id,
        'message' => 'Hello John',
    ]);

    $response->assertSessionHasNoErrors();
    Bus::assertDispatched(SendNotificationMessage::class, 1);
});

it('queues evangelism broadcast messages', function () {
    Bus::fake();

    Lead::create(['name' => 'Lead 1', 'phone' => '0200000001']);
    Lead::create(['name' => 'Lead 2', 'phone' => '0200000002']);

    $response = post(route('evangelism.send'), [
        'channel' => 'whatsapp',
        'broadcast' => true,
        'message' => 'Come join us',
    ]);

    $response->assertSessionHasNoErrors();
    Bus::assertDispatched(SendNotificationMessage::class, 2);
});


