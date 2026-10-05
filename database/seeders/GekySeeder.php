<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GekySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = env('GEKY_ADMIN_PASSWORD');
        if (empty($password)) {
            if ($this->command) $this->command->warn('GEKY_ADMIN_PASSWORD is not set; skipping Geky admin seeding.');
            return;
        }

        $user = User::firstOrCreate(
            ['email' => 'admin@gekychat.com'],
            [
                'name' => 'Geky Admin',
                'email' => 'admin@gekychat.com',
                'phone' => '0240000000',
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Geky admin user created/updated successfully!');
        $this->command->info('Email: admin@gekychat.com');
        $this->command->info('Role: admin');
    }
}
