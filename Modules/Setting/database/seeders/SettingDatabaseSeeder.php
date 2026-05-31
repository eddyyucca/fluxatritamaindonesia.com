<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'app_name', 'value' => 'Fluxa App', 'type' => 'text'],
            ['group' => 'general', 'key' => 'app_desc', 'value' => 'Aplikasi Manajemen Internal', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_name', 'value' => 'PT Fluxa', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_address', 'value' => 'Jakarta, Indonesia', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_phone', 'value' => '021-1234567', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_email', 'value' => 'info@fluxa.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'bank_accounts', 'value' => json_encode([
                ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'PT Fluxa']
            ]), 'type' => 'json'],
            
            // Role Menu
            ['group' => 'role_menu', 'key' => 'role_permissions', 'value' => json_encode([
                'director' => ['dashboard', 'billing', 'recruitment', 'setting'],
                'admin' => ['dashboard', 'billing', 'recruitment']
            ]), 'type' => 'json'],

            // Appearance
            ['group' => 'appearance', 'key' => 'theme_mode', 'value' => 'light', 'type' => 'text'],
            ['group' => 'appearance', 'key' => 'primary_color', 'value' => '#4e73df', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            \Modules\Setting\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
