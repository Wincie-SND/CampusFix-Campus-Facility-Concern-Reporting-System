<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('CAMPUSFIX_ADMIN_EMAIL', 'admin@campusfix.test')],
            [
                'name' => 'CampusFix Administrator',
                'password' => env('CAMPUSFIX_ADMIN_PASSWORD', 'CampusFix123!'),
                'role' => 'admin',
            ],
        );
    }
}
