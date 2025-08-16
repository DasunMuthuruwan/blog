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
            'name' => 'Dasun Muthuruwan',
            'email' => 'dasun@dev-talk.com',
            'username' => 'admin',
            'password' => Hash::make('Dasun@9495'),
            'type' => UserType::SuperAdmin,
            'status' => UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);

        User::create([
            'name' => 'Gayashani Ranasinghe',
            'email' => 'gayashi@dev-talk.com',
            'username' => 'gayshi',
            'password' => Hash::make('GayashiR@$95'),
            'type' => UserType::SuperAdmin,
            'status' => UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);

        User::create([
            'name' => 'Anuradha',
            'email' => 'anuradha@dev-talk.com',
            'username' => 'anuradha',
            'password' => Hash::make('Anuradha@9474'),
            'type' => UserType::Admin,
            'status' => UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);

        User::create([
            'name' => 'Peauticca Thurairajah',
            'email' => 'peauticca@dev-talk.com',
            'username' => 'peauticca',
            'password' => Hash::make('TharuP@$6581'),
            'type' => UserType::Admin,
            'status' => UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);
    }
}
