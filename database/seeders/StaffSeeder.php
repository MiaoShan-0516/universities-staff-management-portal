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
            $date_arr = explode("T", $datetime);
            $date= $date_arr[0];
            
            // $staff_first_name = json_encode($value->name->first);
            // $staff_last_name = json_encode($value->name->last);
            // $fisrt_name_arr = explode('"', $staff_first_name);
            // $last_name_arr = explode('"', $staff_last_name);
            // $staff_full_name = $fisrt_name_arr[2] + ' ' + $last_name_arr[2];

            Staff::create([
                "university_id" => rand(1,146),
                "name" => json_encode($value->name),
                "dob" => $date,
                "email" => $value->email,
                "location" => json_encode($value->location),
                "picture" => $value->picture->large,
                "is_active" => 1,
            ]);
        }
    }
}
