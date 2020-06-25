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
Route::post('/getNotifAd','AnnonceController@getNotifAd');

/* end test */

    Route::post('/message/sending','MessageController@sendMessage');
    Route::post('/message/sendingadmin','MessageController@sendMessageAdmin');
    Route::post('/notVue','MessageController@notVue');
    

    Route::post('/checkNotif','MessageController@checkNotif');
    Route::post('/checkNotifNb','MessageController@checkNotifNb');

    Route::post('/checkAdmNotifNb','MessageController@checkAdmNotifNb');
    Route::post('/checkMessNb','MessageController@checkMessNb');
    Route::post('/getNotif','MessageController@getNotif');

    Route::post('/getMess','MessageController@getMess');
    //Route::post('/signalement','MessageController@sendMessage');
    Route::resource('/user', 'UserController',['except' => ['index']]);
    Route::resource('/adresse', 'AdresseController');
    Route::resource('/seen', 'SeenController');
    Route::resource('/verify', 'VerificationController');

    Route::post('/checkcode','VerificationController@checkcode');
    Route::post('/contact', 'Contact_usController@contact');
    Route::resource('/annonce', 'AnnonceController');
    Route::post('/signalementUser', 'SignalerController@signalUser');
    Route::resource('/signalement', 'SignalerController');
    Route::resource('/sauvegarde', 'AnnonceSavedController');
    Route::post('/user','UserController@index');
    Route::get('/useradmin','UserController@useradmin');
    Route::get('/user','UserController@indexs');

    Route::post('/pwdreset','UserController@pwdreset');
    
    Route::post('/user/UpdateUser','UserController@updateUser');
    Route::post('/user/UpdatePic','UserController@updatePic');
    Route::post('/annonce/look','AnnonceController@searchUs');
    Route::post('/sauvegardedel', 'AnnonceSavedController@savedDel');
    Route::post('/annonce/saved','AnnonceController@adSaved');
    Route::post('/delad','AnnonceController@delMyAd');
    Route::post('/annonce/mysaved','AnnonceController@myadSaved');
    Route::post('/picDown','AnnonceController@picDown');
    Route::post('/annonce/adtodell','AnnonceController@adtomod');

    Route::post('/annonce/mod','AnnonceController@admodifying');

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
    
    