<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\University;

class UniversityController extends Controller
{
    public function getAllUniversity()
    {
        $universities = University::all();

        return response()->json($universities);
    }
}
