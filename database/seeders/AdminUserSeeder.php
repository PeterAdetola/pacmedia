<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Peter Adetola',
            'username'          => 'Pter',
            'email'             => 'peteradetola@gmail.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'status'            => 'approved',
        ]);
    }
}
