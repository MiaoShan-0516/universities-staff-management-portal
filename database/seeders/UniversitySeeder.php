<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;
use File;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        University::truncate();
        $json_data = File::get("database/json/Universities.json");
        $universities = json_decode($json_data);

        foreach ($universities as $key => $value) {
            University::create([
                "name" => $value->name,
                "url" => $value->web_pages[0],
            ]);
        }
    }
}
