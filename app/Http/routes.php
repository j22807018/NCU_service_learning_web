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

Route::get('/', array('uses' => 'HomeController@homePage','as' => 'homepage'));

Route::get('login', array('as' => 'login', 'uses' => 'HomeController@login'));

Route::get('logout', 'HomeController@logout');

Route::post('login', 'HomeController@doLogin');

Route::resource('course', 'CourseController');


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
