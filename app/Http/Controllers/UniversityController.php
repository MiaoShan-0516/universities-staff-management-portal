<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Staff;

class UniversityController extends Controller
{
    public function getAllUniversity()
    {
        $universities = University::all();

        return response()->json($universities);
    }

    public function getUniversityDetails($id)
    {
        $university = University::where('universities.id', '=', $id)->get();
        $staffs = Staff::where('staff.university_id', '=', $id)
            ->where('is_active', '=', '1')->get();
        $arr_university = [];
        $arr_staffs = [];
        
        foreach ($university as $uni) :
            array_push($arr_university, [
                "id" => $uni->id,
                "name" => $uni->name,
                "url" => $uni->url,
            ]);
        endforeach;
        
        foreach ($staffs as $staff) :
            
            array_push($arr_staffs, [
                "id" => $staff->id,
                "name" => json_decode($staff->name),
                "email" => $staff->email,
            ]);
            
        endforeach;


        return response()->json(["university" => $arr_university, "staffs" => $arr_staffs]);
    }

    public function addStaffToUniversity(Request $request)
    {
        $staff = new Staff();
        $staff->university_id = $request->university_id;
        $staff->name = json_encode([
            'first' =>  $request->first,
            'last' =>  $request->last,
        ]);
        $staff->dob = $request->dob;
        $staff->email = $request->email;
        $staff->location = 'location';
        $staff->picture = 'https://randomuser.me/api/portraits/women/33.jpg';
        $staff->is_active = $request->is_active;
        $staff->save();

        return response()->json(["Status" => "success!"]);
    }
}
