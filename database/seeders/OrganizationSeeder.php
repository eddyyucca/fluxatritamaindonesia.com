<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Management
        $directorPass = \Illuminate\Support\Str::random(10);
        $director = \App\Models\User::create([
            'name' => 'Eddy Adha Saputra',
            'email' => 'eddy.adha.saputra@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($directorPass),
            'role' => 'director',
            'position' => 'Director',
            'org_level' => 1,
            'must_change_password' => true,
        ]);
        \Illuminate\Support\Facades\Log::info("Generated Password for Eddy Adha Saputra: {$directorPass}");
        file_put_contents(storage_path('logs/passwords.txt'), "Eddy Adha Saputra: {$directorPass}\n", FILE_APPEND);

        // 2. Operations Manager
        $opsMgrPass = \Illuminate\Support\Str::random(10);
        $opsMgr = \App\Models\User::create([
            'name' => 'Husni Zayyin Ansori',
            'email' => 'husni.zayyin.ansori@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($opsMgrPass),
            'role' => 'user',
            'position' => 'Operations Manager',
            'org_level' => 2,
            'parent_id' => $director->id,
            'must_change_password' => true,
        ]);
        file_put_contents(storage_path('logs/passwords.txt'), "Husni Zayyin Ansori: {$opsMgrPass}\n", FILE_APPEND);

        // 3. Project Support
        $projSupportPass = \Illuminate\Support\Str::random(10);
        $projSupport = \App\Models\User::create([
            'name' => 'Vacant',
            'email' => 'vacant.project@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($projSupportPass),
            'role' => 'user',
            'position' => 'Project Support / Client Support',
            'org_level' => 3,
            'parent_id' => $opsMgr->id,
            'must_change_password' => true,
        ]);
        file_put_contents(storage_path('logs/passwords.txt'), "Vacant: {$projSupportPass}\n", FILE_APPEND);

        // 4. Finance & Admin Manager
        $financeMgrPass = \Illuminate\Support\Str::random(10);
        $financeMgr = \App\Models\User::create([
            'name' => 'Suriyadi',
            'email' => 'suriyadi@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($financeMgrPass),
            'role' => 'user',
            'position' => 'Finance & Administration Manager',
            'org_level' => 2,
            'parent_id' => $director->id,
            'must_change_password' => true,
        ]);
        file_put_contents(storage_path('logs/passwords.txt'), "Suriyadi: {$financeMgrPass}\n", FILE_APPEND);

        // 5. Tech/BisDev Manager
        $techMgrPass = \Illuminate\Support\Str::random(10);
        $techMgr = \App\Models\User::create([
            'name' => 'Chris Rondonuwu',
            'email' => 'chris.rondonuwu@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($techMgrPass),
            'role' => 'user',
            'position' => 'Technology / Business Development Manager',
            'org_level' => 2,
            'parent_id' => $director->id,
            'must_change_password' => true,
        ]);
        file_put_contents(storage_path('logs/passwords.txt'), "Chris Rondonuwu: {$techMgrPass}\n", FILE_APPEND);

        // 6. Developers
        $devs = [
            ['name' => 'Muh.Faisal Lutfi', 'email' => 'muh.faisal.lutfi@fluxa.co.id', 'position' => 'Fullstack Developer 1'],
            ['name' => 'Nur Rahmat Taufiq', 'email' => 'nur.rahmat.taufiq@fluxa.co.id', 'position' => 'Fullstack Developer 2'],
            ['name' => 'Muhammad Seman', 'email' => 'muhammad.seman@fluxa.co.id', 'position' => 'Fullstack Developer 3'],
            ['name' => 'Ali Syahbana', 'email' => 'ali.syahbana@fluxa.co.id', 'position' => 'Fullstack Developer 4'],
        ];

        foreach ($devs as $dev) {
            $pass = \Illuminate\Support\Str::random(10);
            \App\Models\User::create([
                'name' => $dev['name'],
                'email' => $dev['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($pass),
                'role' => 'user',
                'position' => $dev['position'],
                'org_level' => 3,
                'parent_id' => $techMgr->id,
                'must_change_password' => true,
            ]);
            file_put_contents(storage_path('logs/passwords.txt'), "{$dev['name']}: {$pass}\n", FILE_APPEND);
        }

        // 7. IT Infrastructure Manager
        $itMgrPass = \Illuminate\Support\Str::random(10);
        $itMgr = \App\Models\User::create([
            'name' => 'Irfan Cahyadi',
            'email' => 'irfan.cahyadi@fluxa.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make($itMgrPass),
            'role' => 'user',
            'position' => 'IT Infrastructure Manager',
            'org_level' => 2,
            'parent_id' => $director->id,
            'must_change_password' => true,
        ]);
        file_put_contents(storage_path('logs/passwords.txt'), "Irfan Cahyadi: {$itMgrPass}\n", FILE_APPEND);
    }
}
