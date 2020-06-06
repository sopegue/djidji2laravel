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
/*
Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', 'AuthController@user');
    Route::post('logout', 'AuthController@logout');
    });
  });
  
  Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
  });
  
  */
    
    Route::resource('/user', 'UserController',['except' => ['index']]);
    Route::resource('/adresse', 'AdresseController');
    Route::resource('/verify', 'VerificationController');
    Route::resource('/emessage', 'EmessageController',['only' => ['store']]);
    Route::resource('/annonce', 'AnnonceController');
    Route::resource('/reset', 'ResetController');
    Route::post('/user','UserController@index');
    Route::post('/annonce/look','AnnonceController@searchUs');
    Route::post('/annonce/lookcateg','AnnonceController@menuCateg');
    Route::post('/annonce/numbyplace','AnnonceController@numByCateg');
    Route::post('/user/tokenS','UserController@tStore');
    Route::post('/user/check','UserController@checkToken');
    Route::group([

      'middleware' => 'api',
      'prefix' => 'auth'
  
  ], function ($router) {
  
      Route::post('login', 'AuthController@login');
      Route::post('register', 'AuthController@register');
      Route::post('logout', 'AuthController@logout');
      Route::post('refresh', 'AuthController@refresh');
      Route::post('me', 'AuthController@me');
  
  });
    
    