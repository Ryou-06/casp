<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Demo Teacher',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Demo Student',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        User::updateOrCreate(
            ['email' => 'student2@example.com'],
            [
                'name' => 'Demo Student Two',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
    }
}
