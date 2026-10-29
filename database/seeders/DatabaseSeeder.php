<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Admin Blooming',
                'email' => 'admin@blooming.com',
                'password' => 'BloomingAdmin2026!',
                'role' => 'admin',
            ],
            [
                'name' => 'Staff Blooming',
                'email' => 'staff@blooming.com',
                'password' => 'StaffBlooming2026!',
                'role' => 'staff',
            ],
            [
                'name' => 'User Blooming',
                'email' => 'user@blooming.com',
                'password' => 'UserBlooming2026!',
                'role' => 'user',
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'role' => $account['role'],
                ]
            );
        }
    }
}