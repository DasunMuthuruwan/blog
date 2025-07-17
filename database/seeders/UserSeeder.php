<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Admin',
            'email' => 'dasunmuthuruwan9@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('Dasun@123'),
            'type' => UserType::SuperAdmin,
            'status'=>UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);
    }
}
