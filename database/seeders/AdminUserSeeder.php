<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin@gmail.com',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@gmail.com'),
                'user_state' => 'admin', 
            ]
        );
    }
}
