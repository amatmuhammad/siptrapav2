<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ganti password jika perlu
            'is_admin' => true,
        ]);

        // Regular user
        User::create([
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'), // ganti password jika perlu
            'is_admin' => false,
        ]);
    }
}
