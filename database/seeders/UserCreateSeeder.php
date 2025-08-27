<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hasaru Chamikara',
            'email' => 'chamikara@gmail.com',
            'username' => 'hasaru',
            'password' => Hash::make('Hasaru@$6581'),
            'type' => UserType::Admin,
            'status' => UserStatus::Active,
            'password_changed_at' => Carbon::now()
        ]);
    }
}
