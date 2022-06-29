<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/loginValidation', 'App\Http\Controllers\AuthController@userLogin');
Route::get('/getAllUniversity', 'App\Http\Controllers\UniversityController@getAllUniversity');
Route::get('/getUniversityDetails/{id}', 'App\Http\Controllers\UniversityController@getUniversityDetails');
Route::post('/addStaffToUniversity/{id}', 'App\Http\Controllers\UniversityController@addStaffToUniversity');
Route::get('/getStaffDetails/{id}', 'App\Http\Controllers\StaffController@getStaffDetails');
Route::post('/updateStaffDetails', 'App\Http\Controllers\StaffController@updateStaffDetails');
Route::post('/deleteStaff/{id}', 'App\Http\Controllers\StaffController@deleteStaff');

Route::post('sociallogin/{provider}', 'App\Http\Controllers\AuthController@SocialSignup');
