<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function userLogin(Request $request)
    {
        $arr_user = [];
        $loginValidation = User::select('id', 'email')->where('email', '=', $request->email)->where('password', '=', $request->password)->first();
        
        if (User::select('email', 'password')
            ->where('email', '=', $request->email)
            ->where('password', '=', $request->password)
            ->first()
            )
        {
            array_push($arr_user, [
                "id" => $loginValidation->id,
                "email" => $loginValidation->email,
            ]);

            return response()->json($arr_user);
        }
        else {
            return response()->json(['error' => 'login_error'], 401);
        }
    }
}
