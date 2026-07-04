<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'John Admin',
            'email' => 'info@candytech.ng',
            'password' => bcrypt('password123'),
            'is_admin' => true,
            'is_verified' => true,
        ]);
        $admin->wallet()->create(['balance' => 50000]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'ezeobinnahumphry@gmail.com',
            'password' => bcrypt('password123'),
            'is_verified' => false,
        ]);
        $user->wallet()->create(['balance' => 0]);

        // Default Settings
        \App\Models\Setting::create(['key' => 'monnify_base_url', 'value' => 'https://sandbox.monnify.com']);
        \App\Models\Setting::create(['key' => 'monnify_api_key', 'value' => 'MK_TEST_XXXXXXXXXX']);
        \App\Models\Setting::create(['key' => 'monnify_secret_key', 'value' => 'XXXXXXXXXXXXXXXXXXXX']);
        \App\Models\Setting::create(['key' => 'monnify_contract_code', 'value' => 'XXXXXXXXXX']);
        \App\Models\Setting::create(['key' => 'profit_percentage', 'value' => '10']);
        \App\Models\Setting::create(['key' => 'vtpass_api_key', 'value' => '']);
        \App\Models\Setting::create(['key' => 'vtpass_public_key', 'value' => '']);
    }
}
