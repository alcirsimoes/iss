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
    if (Auth::check())
        return redirect('home');

    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/admin/{user}', 'UserController@admin')->name('user.admin');
Route::get('user/supervisor/{user}', 'UserController@supervisor')->name('user.supervisor');

Route::resource('user', 'UserController');
Route::resource('survey', 'SurveyController');
Route::resource('sample', 'SampleController');
Route::resource('subject', 'SubjectController');
Route::resource('question', 'QuestionController');

Route::get('form/{survey}/{subject?}', 'FormController@index')->name('form.index');

Route::post('form/current', 'FormController@current')->name('form.current');
Route::post('form/next', 'FormController@next')->name('form.next');
Route::post('form/previous/{question}', 'FormController@previous')->name('form.previous');

Route::get('form/{survey}/{subject}', 'FormController@index')->name('form.create');
Route::post('form/{survey}/{subject}', 'FormController@store')->name('form.store');
