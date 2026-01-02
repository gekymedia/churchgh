<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Service;
use App\Models\Attendance;
use App\Models\Tithe;
use App\Models\Offering;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Followup;
use App\Models\Lead;
use App\Models\Ministry;
use App\Models\Giving;
use App\Models\Quote;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create Ministries
        $worship = Ministry::create([
            'name' => 'Worship Ministry',
            'description' => 'Leading worship and music during services'
        ]);
        $youth = Ministry::create([
            'name' => 'Youth Ministry',
            'description' => 'Youth programs and activities'
        ]);
        $children = Ministry::create([
            'name' => 'Children Ministry',
            'description' => 'Sunday school and children programs'
        ]);
        $evangelism = Ministry::create([
            'name' => 'Evangelism Ministry',
            'description' => 'Outreach and evangelism activities'
        ]);
        $prayer = Ministry::create([
            'name' => 'Prayer Ministry',
            'description' => 'Intercessory prayer and prayer meetings'
        ]);

        // Create Members
        $members = [];
        $memberData = [
            ['John', 'Mensah', '0205440495', 'john.mensah@example.com', 'male', 'married', 'active'],
            ['Mary', 'Owusu', '0240000001', 'mary.owusu@example.com', 'female', 'married', 'active'],
            ['Kofi', 'Asante', '0240000002', 'kofi.asante@example.com', 'male', 'single', 'active'],
            ['Ama', 'Boateng', '0240000003', 'ama.boateng@example.com', 'female', 'married', 'active'],
            ['Kwame', 'Adjei', '0240000004', 'kwame.adjei@example.com', 'male', 'single', 'active'],
            ['Akosua', 'Darko', '0240000005', 'akosua.darko@example.com', 'female', 'married', 'active'],
            ['Yaw', 'Osei', '0240000006', 'yaw.osei@example.com', 'male', 'married', 'active'],
            ['Efua', 'Agyeman', '0240000007', 'efua.agyeman@example.com', 'female', 'single', 'active'],
            ['Kojo', 'Appiah', '0240000008', 'kojo.appiah@example.com', 'male', 'married', 'active'],
            ['Adwoa', 'Tetteh', '0240000009', 'adwoa.tetteh@example.com', 'female', 'married', 'active'],
            ['Nana', 'Amoah', '0240000010', 'nana.amoah@example.com', 'male', 'single', 'active'],
            ['Abena', 'Frimpong', '0240000011', 'abena.frimpong@example.com', 'female', 'married', 'active'],
            ['Fiifi', 'Sarpong', '0240000012', 'fiifi.sarpong@example.com', 'male', 'single', 'active'],
            ['Maame', 'Gyasi', '0240000013', 'maame.gyasi@example.com', 'female', 'married', 'active'],
            ['Kweku', 'Bonsu', '0240000014', 'kweku.bonsu@example.com', 'male', 'married', 'active'],
        ];

        foreach ($memberData as $data) {
            $members[] = Member::create([
                'first_name' => $data[0],
                'last_name' => $data[1],
                'phone' => $data[2],
                'email' => $data[3],
                'gender' => $data[4],
                'marital_status' => $data[5],
                'membership_status' => $data[6],
                'dob' => Carbon::now()->subYears(rand(20, 60))->subDays(rand(0, 365)),
                'address' => rand(1, 100) . ' Main Street, Accra',
            ]);
        }

        // Assign members to ministries
        $members[0]->ministries()->attach([$worship->id, $prayer->id]);
        $members[1]->ministries()->attach([$children->id]);
        $members[2]->ministries()->attach([$youth->id, $evangelism->id]);
        $members[3]->ministries()->attach([$worship->id]);
        $members[4]->ministries()->attach([$youth->id]);
        $members[5]->ministries()->attach([$children->id, $prayer->id]);
        $members[6]->ministries()->attach([$evangelism->id]);
        $members[7]->ministries()->attach([$worship->id, $youth->id]);
        $members[8]->ministries()->attach([$prayer->id]);
        $members[9]->ministries()->attach([$children->id]);

        // Create Users (Pastors, Leaders, Members)
        $pastor = User::create([
            'name' => 'Pastor Samuel',
            'email' => 'pastor@churchgh.com',
            'phone' => '0205000001',
            'password' => Hash::make('password'),
            'role' => 'pastor',
        ]);

        $leader = User::create([
            'name' => 'Leader Grace',
            'email' => 'leader@churchgh.com',
            'phone' => '0205000002',
            'password' => Hash::make('password'),
            'role' => 'leader',
        ]);

        // Create member users
        $memberUsers = [];
        for ($i = 0; $i < 5; $i++) {
            $memberUsers[] = User::create([
                'name' => $members[$i]->first_name . ' ' . $members[$i]->last_name,
                'email' => $members[$i]->email,
                'phone' => $members[$i]->phone,
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_id' => $members[$i]->id,
                'receive_quote_email' => rand(0, 1),
                'receive_event_reminder_email' => rand(0, 1),
            ]);
        }

        // Create Services (past 4 weeks and next 4 weeks)
        $services = [];
        for ($i = -4; $i <= 4; $i++) {
            $date = Carbon::now()->startOfWeek()->addWeeks($i)->addDays(6)->setTime(9, 0);
            $services[] = Service::create([
                'name' => 'Sunday Service',
                'starts_at' => $date,
                'location' => 'Main Auditorium',
                'notes' => $i < 0 ? 'Past service' : ($i == 0 ? 'Today\'s service' : 'Upcoming service'),
            ]);
        }

        // Create Attendances for past services
        foreach (array_slice($services, 0, 4) as $service) {
            $attendedMembers = collect($members)->random(rand(8, 12));
            foreach ($attendedMembers as $member) {
                Attendance::create([
                    'service_id' => $service->id,
                    'member_id' => $member->id,
                    'status' => collect(['present', 'present', 'present', 'online'])->random(),
                    'notes' => rand(0, 1) ? 'Regular attendee' : null,
                ]);
            }
        }

        // Create Tithes (past 3 months)
        for ($i = 0; $i < 30; $i++) {
            $member = collect($members)->random();
            Tithe::create([
                'member_id' => $member->id,
                'amount' => rand(50, 500),
                'paid_at' => Carbon::now()->subDays(rand(0, 90)),
                'reference' => 'TITHE-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'notes' => rand(0, 1) ? 'Monthly tithe' : null,
            ]);
        }

        // Create Offerings (past 3 months)
        $offeringCategories = ['Sunday', 'Special', 'Building Fund', 'Missions', 'Thanksgiving'];
        for ($i = 0; $i < 40; $i++) {
            $member = rand(0, 1) ? collect($members)->random() : null;
            Offering::create([
                'member_id' => $member?->id,
                'amount' => rand(20, 300),
                'category' => collect($offeringCategories)->random(),
                'paid_at' => Carbon::now()->subDays(rand(0, 90)),
                'reference' => 'OFF-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'notes' => rand(0, 1) ? 'Thankful offering' : null,
            ]);
        }

        // Create Events (past and upcoming)
        $events = [];
        $eventTitles = [
            'Prayer Conference',
            'Youth Camp',
            'Women\'s Conference',
            'Men\'s Breakfast',
            'Children\'s Day',
            'Thanksgiving Service',
            'Christmas Concert',
            'New Year Service',
            'Baptism Service',
            'Leadership Training',
        ];

        for ($i = 0; $i < 10; $i++) {
            $startsAt = Carbon::now()->addDays(rand(-30, 60))->setTime(rand(9, 18), 0);
            $endsAt = $startsAt->copy()->addHours(rand(2, 4));
            
            $events[] = Event::create([
                'title' => $eventTitles[$i],
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'location' => collect(['Main Auditorium', 'Annex Hall', 'Outdoor', 'Conference Room'])->random(),
                'description' => 'Join us for ' . strtolower($eventTitles[$i]) . '. All are welcome!',
            ]);
        }

        // Create Event Registrations
        foreach ($events as $event) {
            if ($event->starts_at->isFuture()) {
                $registeredUsers = collect($memberUsers)->random(rand(2, 4));
                foreach ($registeredUsers as $user) {
                    EventRegistration::create([
                        'event_id' => $event->id,
                        'user_id' => $user->id,
                        'registered_at' => Carbon::now()->subDays(rand(0, 7)),
                    ]);
                }
            }
        }

        // Create Followups
        $followupCategories = ['Visit', 'Call', 'Prayer', 'Counseling', 'Discipleship'];
        for ($i = 0; $i < 15; $i++) {
            $member = collect($members)->random();
            $followupDate = Carbon::now()->addDays(rand(-7, 14));
            
            Followup::create([
                'member_id' => $member->id,
                'category' => collect($followupCategories)->random(),
                'followup_date' => $followupDate,
                'assigned_user_id' => rand(0, 1) ? $pastor->id : $leader->id,
                'note' => 'Follow up with ' . $member->first_name . ' regarding ' . collect(['prayer request', 'visitation', 'counseling', 'ministry involvement'])->random(),
                'status' => $followupDate->isPast() ? collect(['pending', 'completed'])->random() : 'pending',
                'completed_at' => $followupDate->isPast() && rand(0, 1) ? $followupDate->copy()->addDays(rand(0, 2)) : null,
            ]);
        }

        // Create Leads
        $leadNames = [
            ['Emmanuel', 'Kwarteng', '0241000001', 'emmanuel.k@example.com'],
            ['Priscilla', 'Amoako', '0241000002', 'priscilla.a@example.com'],
            ['Daniel', 'Ofori', '0241000003', 'daniel.o@example.com'],
            ['Ruth', 'Mensah', '0241000004', 'ruth.m@example.com'],
            ['Joseph', 'Agyeman', '0241000005', 'joseph.a@example.com'],
            ['Hannah', 'Boateng', '0241000006', 'hannah.b@example.com'],
            ['David', 'Asante', '0241000007', 'david.a@example.com'],
            ['Esther', 'Owusu', '0241000008', 'esther.o@example.com'],
        ];

        foreach ($leadNames as $lead) {
            Lead::create([
                'name' => $lead[0] . ' ' . $lead[1],
                'phone' => $lead[2],
                'email' => $lead[3],
                'notes' => collect([
                    'Interested in joining the church',
                    'Came for first time last Sunday',
                    'Requested prayer',
                    'Interested in youth ministry',
                    'Wants to know more about baptism',
                ])->random(),
            ]);
        }

        // Create Givings (online giving)
        $givingTypes = ['tithe', 'offering', 'building', 'missions', 'special'];
        $methods = ['mobile_money', 'card', 'bank_transfer'];
        
        for ($i = 0; $i < 20; $i++) {
            $user = collect($memberUsers)->random();
            Giving::create([
                'user_id' => $user->id,
                'member_id' => $user->member_id,
                'type' => collect($givingTypes)->random(),
                'amount' => rand(50, 1000),
                'is_anonymous' => rand(0, 1),
                'note' => rand(0, 1) ? 'Thankful giving' : null,
                'reference' => 'GIV-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'method' => collect($methods)->random(),
                'paid_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }

        // Create Quotes (daily inspirational quotes)
        $scriptures = [
            'Jeremiah 29:11',
            'Philippians 4:13',
            'Proverbs 3:5-6',
            'Isaiah 40:31',
            'Romans 8:28',
            'Joshua 1:9',
            'Matthew 6:33',
            'Psalm 23:1',
            '1 Corinthians 13:4-5',
            'Ephesians 2:8-9',
        ];

        $messages = [
            'Trust in the Lord with all your heart and lean not on your own understanding.',
            'I can do all things through Christ who strengthens me.',
            'For I know the plans I have for you, declares the Lord.',
            'But those who hope in the Lord will renew their strength.',
            'And we know that in all things God works for the good.',
            'Be strong and courageous. Do not be afraid.',
            'But seek first his kingdom and his righteousness.',
            'The Lord is my shepherd, I lack nothing.',
            'Love is patient, love is kind.',
            'For it is by grace you have been saved.',
        ];

        for ($i = 0; $i < 14; $i++) {
            $deliveryDate = Carbon::now()->addDays($i);
            $quoteIndex = $i % count($scriptures);
            
            Quote::create([
                'title' => 'Daily Inspiration',
                'scripture' => $scriptures[$quoteIndex],
                'message' => $messages[$quoteIndex],
                'delivery_date' => $deliveryDate,
                'delivery_time' => '06:00:00',
                'sent_at' => $deliveryDate->isPast() ? $deliveryDate->copy()->setTime(6, 0) : null,
            ]);
        }

        $this->command->info('✅ Seeded all tables successfully!');
        $this->command->info('   - ' . count($members) . ' Members');
        $this->command->info('   - ' . count($services) . ' Services');
        $this->command->info('   - ' . Attendance::count() . ' Attendance records');
        $this->command->info('   - ' . Tithe::count() . ' Tithes');
        $this->command->info('   - ' . Offering::count() . ' Offerings');
        $this->command->info('   - ' . count($events) . ' Events');
        $this->command->info('   - ' . EventRegistration::count() . ' Event Registrations');
        $this->command->info('   - ' . Followup::count() . ' Followups');
        $this->command->info('   - ' . Lead::count() . ' Leads');
        $this->command->info('   - ' . Ministry::count() . ' Ministries');
        $this->command->info('   - ' . Giving::count() . ' Givings');
        $this->command->info('   - ' . Quote::count() . ' Quotes');
    }
}
