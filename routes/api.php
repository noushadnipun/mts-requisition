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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** Project*/
Route::get('getproject', function(){
	$project = \Tritiyo\Project\Models\Project::get();
  	return response()->json($project);
});

Route::get('getuser', function(){
	$user = \App\Models\User::get();
  	return response()->json($user);
});

