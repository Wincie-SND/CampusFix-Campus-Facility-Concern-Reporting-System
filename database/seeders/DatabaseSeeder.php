<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('CAMPUSFIX_ADMIN_EMAIL', 'admin@campusfix.test')],
            [
                'name' => 'CampusFix Administrator',
                'password' => env('CAMPUSFIX_ADMIN_PASSWORD', 'CampusFix123!'),
                'role' => 'staff',
            ],
        );

        $accounts = [
            ['name' => 'CampusFix Student One', 'email' => 'student1@campusfix.test'],
            ['name' => 'CampusFix Student Two', 'email' => 'student2@campusfix.test'],
            ['name' => 'CampusFix Student Three', 'email' => 'student3@campusfix.test'],
            ['name' => 'CampusFix Guest', 'email' => 'guest@campusfix.test', 'role' => 'guest', 'password' => 'GuestFix123!'],
            ['name' => 'CampusFix Faculty', 'email' => 'faculty@campusfix.test', 'role' => 'faculty', 'password' => 'FacultyFix123!'],
            ['name' => 'CampusFix Staff', 'email' => 'staff@campusfix.test', 'role' => 'staff', 'password' => 'StaffFix123!'],
        ];

        foreach ($accounts as $account) {
            $role = $account['role'] ?? 'student';

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => $account['password'] ?? 'StudentFix123!',
                    'role' => $role,
                ],
            );
        }
    }
}
