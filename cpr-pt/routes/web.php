<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

//BLADES
Route::get('/content', 'BladesController@contentIndex');

Route::get('/history', 'BladesController@historyIndex');

Route::get('/students', 'BladesController@studentsIndex')->middleware('teacher');

Route::get('/newSession', 'NewSessionController@index');

//NEW SESSION
Route::post('/startSession/', 'NewSessionController@startSession');

Route::post('/curSession/{id}/', 'NewSessionController@newExercise');

Route::get('/exercise_progress/{id}','NewSessionController@live_info');


//SESSIONS CONTROLLER
Route::get('/history/{id}/session', 'SessionsController@session');

Route::get('/students/{id}/sessions', 'SessionsController@sessions')->middleware('teacher');

Route::get('/students/{id}/session', 'SessionsController@session')->middleware('teacher');

Route::get('/progress/{id}', 'SessionsController@progress');

//COMMENTS
Route::post('/comments/{session_id}{user_id}', 'CommentsController@send');

Route::get('/comments/open/{id}{sessionId}', 'CommentsController@mark');

Route::get('/comments/new','CommentsController@newComments');

Route::get('/comments/{id}', 'CommentsController@comments');

//TURMAS
Route::get('/turmas/{id}', 'TurmasController@turmas')->middleware('teacher');;

Route::get('/turma/{id}', 'TurmasController@studentsIndex')->middleware('teacher');;

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


