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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});

Route::get('project/filter','App\Http\Controllers\ProjectController@filter')->middleware('api');
Route::resource('projects','App\Http\Controllers\ProjectController')->middleware('api');
Route::get('tasks/filter','App\Http\Controllers\TaskController@filter')->middleware('api');
Route::resource('task','App\Http\Controllers\TaskController')->middleware('api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
