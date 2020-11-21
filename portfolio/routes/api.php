<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/schedule', 'Api\ScheduleController@index');

Route::middleware('auth:api')->put('/schedule', 'Api\ScheduleController@update');

Route::middleware('auth:api')->post('/schedule', 'Api\ScheduleController@store');

Route::middleware('auth:api')->delete('/schedule/{schedule}', 'Api\ScheduleController@destroy');

Route::middleware('auth:api')->get('/schedule/search', 'Api\ScheduleController@show');
