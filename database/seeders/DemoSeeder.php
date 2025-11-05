<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Member;
use App\Models\Service;
use App\Models\Attendance;
use App\Models\Tithe;
use App\Models\Offering;
use App\Models\Event;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Members
        $john = Member::create([
            'first_name' => 'John', 'last_name' => 'Mensah',
            'phone' => '0205440495', 'email' => 'john@example.com',
            'gender' => 'male', 'membership_status' => 'active'
        ]);
        $mary = Member::create([
            'first_name' => 'Mary', 'last_name' => 'Owusu',
            'phone' => '0240000000', 'email' => 'mary@example.com',
            'gender' => 'female', 'membership_status' => 'active'
        ]);

        // Services
        $svc = Service::create([
            'name' => 'Sunday Service',
            'starts_at' => Carbon::now()->startOfWeek()->addDays(6)->setTime(9,0),
            'location' => 'Main Auditorium',
            'notes' => 'Main weekly service'
        ]);

        // Attendance
        Attendance::create(['service_id'=>$svc->id,'member_id'=>$john->id,'status'=>'present']);
        Attendance::create(['service_id'=>$svc->id,'member_id'=>$mary->id,'status'=>'present']);

        // Tithes & Offerings
        Tithe::create(['member_id'=>$john->id,'amount'=>150.00,'paid_at'=>Carbon::now(),'reference'=>'TITHE-001']);
        Offering::create(['member_id'=>$mary->id,'amount'=>50.00,'category'=>'Sunday','paid_at'=>Carbon::now(),'reference'=>'OFF-001']);

        // Event
        Event::create([
            'title'=>'Prayer Conference',
            'starts_at'=>Carbon::now()->addDays(14)->setTime(18,0),
            'ends_at'=>Carbon::now()->addDays(14)->setTime(21,0),
            'location'=>'Annex Hall',
            'description'=>'A night of prayer and worship.'
        ]);
    }
}
