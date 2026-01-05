<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'manager@local.test'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user1@local.test'],
            [
                'name' => 'User One',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@local.test'],
            [
                'name' => 'User Two',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );
    
    }
}
