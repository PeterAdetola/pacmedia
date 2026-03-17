<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin User'),
                'password' => Hash::make(
                    env('ADMIN_PASSWORD', 'password')
                ),
                'email_verified_at' => now(),
            ]
        );


        $this->command?->info('Admin user ensured.');
    }
}
