<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/home', 'HomeController@index');

Route::get('/import', 'ImportExportController@import');

//BLADES
Route::get('/content', 'BladesController@contentIndex');

Route::get('/students', 'BladesController@studentsIndex');

Route::get('/newSession', 'NewSessionController@index');

//NEW SESSION
Route::post('/startSession/', 'NewSessionController@startSession');

Route::post('/curSession/{id}&{curExercise}/', 'NewSessionController@newExercise');

Route::post('/endSession/{curExercise}/', 'NewSessionController@endSession');

//SIMULATION CONTROLLER

Route::get('/exercise_progress/{id}','SimulationController@live_info');

Route::get('/script/{id}&{sim}','SimulationController@script');


//SESSIONS CONTROLLER

Route::get('/history/{id}/sessions', 'SessionsController@sessions');

Route::get('/history/{id}/session', 'SessionsController@session');

Route::get('/students/{id}/sessions', 'SessionsController@sessions')->middleware('teacher');

Route::get('/students/{id}/session', 'SessionsController@session')->middleware('teacher');

Route::get('/progress/{id}', 'SessionsController@progress');

Route::get('/exercises/{id}', 'SessionsController@userExercises');
//COMMENTS

Route::get('/comments', 'CommentsController@comments');

//TURMAS
Route::get('/turmas/{id}', 'TurmasController@turmas')->middleware('teacher');;

Route::get('/turma/{id}', 'TurmasController@studentsIndex')->middleware('teacher');;

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/exercise_results/{id}', 'SessionsController@exercise');
