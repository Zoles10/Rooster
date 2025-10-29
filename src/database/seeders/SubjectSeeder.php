<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
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
