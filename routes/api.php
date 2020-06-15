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
/*for test */

Route::post('/annonce/testfile','AnnonceController@testfile');

/* end test */
    
    Route::resource('/user', 'UserController',['except' => ['index']]);
    Route::resource('/adresse', 'AdresseController');
    Route::resource('/verify', 'VerificationController');
    Route::resource('/emessage', 'EmessageController',['only' => ['store']]);
    Route::resource('/annonce', 'AnnonceController');
    Route::resource('/reset', 'ResetController');
    Route::post('/user','UserController@index');
    Route::post('/user/UpdateUser','UserController@updateUser');
    Route::post('/user/UpdatePic','UserController@updatePic');
    Route::post('/annonce/look','AnnonceController@searchUs');

    Route::post('/annonce/saved','AnnonceController@adSaved');

    Route::get('/annonce/{id}','AnnonceController@vAnnonce');
    Route::get('/user/{id}','UserController@vUser');

    Route::post('/savedAdsCheck','AnnonceSavedController@savedAdsCheck');

    Route::post('/annonce/lookcateg','AnnonceController@menuCateg');
    Route::post('/annonce/looksouscateg','AnnonceController@sousCategSearch');
    Route::post('/annonce/lookbywhat','AnnonceController@whatLook');
    Route::post('/annonce/numbyplace','AnnonceController@numByCateg');
    Route::post('/user/tokenS','UserController@tStore');
    Route::post('/user/pwdUpdate','UserController@pwdUpdate');
    Route::post('/user/check','UserController@checkToken');
    Route::post('/user/checkUserExistance','UserController@checkExistance');
    Route::post('/user/checkUserExistanceUpdate','UserController@checkExistanceUpdate');
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
    
    