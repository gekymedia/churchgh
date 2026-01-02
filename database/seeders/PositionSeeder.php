<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            [
                'name' => 'elder',
                'description' => 'Church elder - spiritual leader and advisor',
            ],
            [
                'name' => 'deacon',
                'description' => 'Deacon - serves in various church ministries',
            ],
            [
                'name' => 'deaconess',
                'description' => 'Deaconess - serves in various church ministries',
            ],
            [
                'name' => 'shepherd',
                'description' => 'Shepherd - assigned to care for a group of members (flock)',
            ],
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate(
                ['name' => $position['name']],
                $position
            );
        }
    }
}
