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
    Route::get('/', 'CourseController@index');
	Route::get('login', 'AuthController@auth');
	Route::get('logout', 'AuthController@logout');
    Route::resource('course', 'CourseController');
    Route::resource('course', 'CourseController');
    Route::get('course/{id}/announce', array('uses' => 'CourseController@announce', 'as' => 'course.announce'));
    Route::get('course/{id}/hide', array('uses' => 'CourseController@hide', 'as' => 'course.hide'));
    Route::post('course/{id}/file_upload', array('uses' => 'FileController@upload', 'as' => 'file.upload'));
    Route::get('file/{id}', array('uses' => 'FileController@download', 'as' => 'file.download'));
    Route::delete('file/{id}', array('uses' => 'FileController@destroy', 'as' => 'file.destroy'));
    Route::get('course/{id}/log/', array('uses' => 'LogController@show', 'as' => 'log.show'));

    Route::get('questionnaire', array('uses' => 'QuestionnaireController@index', 'as' => 'questionnaire.index'));
    Route::get('questionnaire/{id}', array('uses' => 'QuestionnaireController@show', 'as' => 'questionnaire.show'));
    Route::post('questionnaire/{id}', array('uses' => 'QuestionnaireController@store', 'as' => 'questionnaire.store'));
});
