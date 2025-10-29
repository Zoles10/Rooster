<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            "name" => "admin",
            "email" => "admin@admin.sk",
            "admin" => 1,
            "password" => \Illuminate\Support\Facades\Hash::make('admin'),
        ]);

        User::factory()->create([
            "name" => "user1",
            "email" => "user1@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user2",
            "email" => "user2@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user3",
            "email" => "user3@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user4",
            "email" => "user4@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);
    }
}
