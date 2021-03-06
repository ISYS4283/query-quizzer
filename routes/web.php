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

Route::view('/', 'welcome', ['title' => 'Query Quizzer Welcome']);

Route::name('login')->get('/login', '\\'.Route::getRoutes()->getByName('shibboleth-login')->getActionName());

Route::group(['middleware' => ['auth']], function () {
    Route::resource('connections', 'ConnectionController');
    Route::resource('queries', 'QueryController');
    Route::post('/queries/create', 'QueryController@create');
    Route::name('quizzes.blackboard')->get('/quizzes/{quiz}/blackboard', 'QuizController@blackboard');
    Route::resource('quizzes', 'QuizController');
    Route::resource('quizzes.queries', 'QueryQuizController');
    Route::name('quizzes.queries.attempt')->post('/quizzes/{quiz}/queries/{query}', 'QueryQuizController@attempt');
});
