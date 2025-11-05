<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(User::class)) return;
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator','password' => Hash::make('password'),'role'=>'admin','phone'=>'0205440495']
        );
    }
}
