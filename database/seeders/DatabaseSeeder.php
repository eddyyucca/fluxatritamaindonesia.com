<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Director account (you)
        User::firstOrCreate(
            ['email' => 'eddy@fluxaborneo.tech'],
            [
                'name'     => 'Eddy Adha Saputra',
                'password' => Hash::make('fluxa2026'),
                'role'     => 'director',
                'position' => 'Director',
            ]
        );

        // Example staff account
        User::firstOrCreate(
            ['email' => 'staff@fluxaborneo.tech'],
            [
                'name'     => 'Staff Fluxa',
                'password' => Hash::make('fluxa2026'),
                'role'     => 'user',
                'position' => 'Web Developer',
            ]
        );
    }
}
