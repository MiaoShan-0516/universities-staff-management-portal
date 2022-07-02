<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\University;

class StaffController extends Controller
{
    public function getStaffDetails($id, $uniId)
    {
        $staff = Staff::where('staff.id', '=', $id)->get();
        $university = University::where('universities.id', '=', $uniId)->get();
        $arr_staff = [];
        
        foreach ($staff as $user) :
            array_push($arr_staff, [
                "id" => $user->id,
                "university_id" => $user->university_id,
                "name" => json_decode($user->name),
                "dob" => $user->dob,
                "email" => $user->email,
                "location" => json_decode($user->location),
                "picture" => $user->picture,
                "is_active" => $user->is_active,
            ]);
        endforeach;
        

        return response()->json(["staff" => $arr_staff, "birthday" => $user->dob, "university" => $university]);
    }

    public function updateStaffDetails(Request $request)
    {
        $staff = Staff::find($request->id);
        $staff->university_id = $request->university_id;
        $staff->name = json_encode([
            'first' =>  $request->first,
            'last' =>  $request->last,
        ]);
        $staff->dob = $request->dob;
        $staff->email = $request->email;
        $staff->location = 'location';
        $staff->picture = $request->picture;
        $staff->is_active = $request->is_active;
        $staff->save();

        return response()->json(["Status" => "success!"]);
    }

    public function deleteStaff(Request $request)
    {
        $staff = Staff::where('staff.id', '=', $request->id)->delete();

        return response()->json(["Status" => "deleted!"]);
    }
}
