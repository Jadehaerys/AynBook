<?php

namespace Database\Seeders;

use App\Models\Record;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Demo admin account ─────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@aynbook.com'],
            [
                'name'     => 'AynBook Admin',
                'password' => Hash::make('Admin1234!'),
                'role'     => 'admin',
            ]
        );

        // ── Demo regular user ──────────────────────────────────────────────
        $user = User::firstOrCreate(
            ['email' => 'user@aynbook.com'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('User1234!'),
                'role'     => 'user',
            ]
        );

        // ── Sample contact records for the regular user ────────────────────
        $sampleRecords = [
            ['name' => 'Ayn Dela Cruz',    'email' => 'ayn@example.com',    'phone' => '+63 912 345 6789', 'address' => 'Liloan, Cebu',    'notes' => 'Best person ever'],
            ['name' => 'Maria Santos',     'email' => 'maria@example.com',  'phone' => '+63 917 111 2233', 'address' => 'Cebu City',        'notes' => 'College friend'],
            ['name' => 'Juan Reyes',       'email' => 'juan@example.com',   'phone' => '+63 920 999 8877', 'address' => 'Mandaue City',     'notes' => 'Classmate'],
            ['name' => 'HR — TechCorp PH', 'email' => 'hr@techcorp.ph',     'phone' => '+63 32 888 0001',  'address' => 'IT Park, Cebu',    'notes' => 'Sent resume May 2026'],
            ['name' => 'Lolo Ben',         'email' => null,                  'phone' => '+63 915 444 3322', 'address' => 'Consolacion, Cebu', 'notes' => 'Call every Sunday'],
        ];

        foreach ($sampleRecords as $record) {
            Record::firstOrCreate(
                ['user_id' => $user->id, 'name' => $record['name']],
                array_merge($record, ['user_id' => $user->id])
            );
        }
    }
}
