<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        // Dummy Users
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

        // Subjects
        Subject::factory()->create([
            "subject" => "WEBTE2",
        ]);

        Subject::factory()->create([
            "subject" => "VSA",
        ]);

        Subject::factory()->create([
            "subject" => "UHD",
        ]);
    }
}
