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





Route::get('domains/{key}', 'APIController@domains');
Route::get('messages/{email}/{key}', 'APIController@messages'); 
Route::get('message/{id}/{key}', 'APIController@message'); 
Route::post('email/create/{key}', 'APIController@email_create'); 
Route::post('email/delete/{email}/{key}', 'APIController@email_delete');
Route::post('email/change/{email}/{username}/{domain}/{key}', 'APIController@email_change');
Route::post('message/delete/{id}/{key}', 'APIController@message_delete');




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
