<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use File;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::truncate();
        $json_data = File::get("database/json/Staff.json");
        $staff = json_decode($json_data);
        

        foreach ($staff as $key => $value) {
            $datetime = $value->dob->date;
            $date_arr= explode("T", $datetime);
            $date= $date_arr[0];

            Staff::create([
                "university_id" => rand(1,146),
                "name" => json_encode($value->name->first),
                "dob" => $date,
                "email" => $value->email,
                "location" => json_encode($value->location),
                "picture" => $value->picture->large,
                "is_active" => 1,
            ]);
        }
    }
}
