<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', array('uses' => 'CourseController@index','as' => 'homepage'));

//Route::post('login', 'HomeController@doLogin');
Route::group(['middleware' => ['web']], function () {

	Route::get('login', 'AuthController@auth');
	Route::get('logout', 'AuthController@logout');
    Route::resource('course', 'CourseController');
    Route::post('course/{id}/file_upload', array('uses' => 'FileController@upload', 'as' => 'file.upload'));
    Route::get('file/{id}', array('uses' => 'FileController@download', 'as' => 'file.download'));
});


// Route::get('auth', 'AuthController@auth');
// Route::get('auth/login', 'AuthController@login');
// Route::delete('auth/logout', 'AuthController@logout');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
