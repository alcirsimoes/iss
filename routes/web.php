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

Route::get('user/set_admin/{user}', 'UserController@setAdmin')->name('user.setAdmin');
Route::get('user/unset_admin/{user}', 'UserController@unsetAdmin')->name('user.unsetAdmin');
Route::get('user/set_supervisor/{user}', 'UserController@setSupervisor')->name('user.setSupervisor');
Route::get('user/unset_supervisor/{user}', 'UserController@unsetSupervisor')->name('user.unsetSupervisor');

Route::resource('user', 'UserController');
Route::resource('survey', 'SurveyController');
Route::resource('sample', 'SampleController');
Route::resource('subject', 'SubjectController');
Route::resource('question', 'QuestionController');

Route::get('email/{survey}/{sample}/{subject}', 'DirectController@email')->name('direct.email');
Route::get('f/{token?}', 'DirectController@login')->name('direct.login');
Route::post('f/current', 'DirectController@current')->name('direct.current');
Route::post('f/next', 'DirectController@next')->name('direct.next');
Route::post('f/previous', 'DirectController@next')->name('direct.previous');

Route::get('form/{survey}/{subject?}', 'FormController@index')->name('form.index');

Route::post('form/current', 'FormController@current')->name('form.current');
Route::post('form/next', 'FormController@next')->name('form.next');
Route::post('form/previous', 'FormController@next')->name('form.previous');

Route::get('form/{survey}/{subject}', 'FormController@index')->name('form.create');
Route::post('form/{survey}/{subject}', 'FormController@store')->name('form.store');

Route::get('monitoring/{survey}', 'ReportController@index')->name('report.index');
Route::get('monitoring/{survey}/{sample}', 'ReportController@list')->name('report.list');
Route::get('monitoring/{survey}/{sample}/{subject}', 'ReportController@view')->name('report.view');

Route::get('teste', function () {
    if (Auth::check()){
        $ids = [
            1 => 0,
            2 => 1,
            3 => 2,
            4 => 3,
            5 => 99,
            6 => 4,
            7 => null,
            8 => null,
            9 => null,
            10 => null,
            11 => null,
            12 => null,
            13 => 5,
            14 => 6,
            15 => null,
            16 => 7,
            17 => null,
            18 => 8,
            19 => null,
            20 => 9,
            21 => null,
            22 => 10,
            23 => null,
            24 => 11,
            25 => null,
            26 => 12,
            27 => null,
            28 => 13,
            29 => null,
            30 => 14,
            31 => 15,
            32 => null,
            33 => 16,
            34 => 17,
            35 => 18,
            35 => 18,
            36 => null,
            37 => null,
            38 => null,
            39 => null,
            40 => 19,
            41 => 20,
            42 => 21,
            43 => 22,
            44 => 23,
            45 => 24,
        ];

        $questions = [];
        foreach ($ids as $k => $v) {
            $question = App\Question::find($k);
            $question->order = $v;
            $question->save();

            $questions [] = $question;
        }

        return $questions;
    }

    // if (Auth::check()){
    //     $survey = App\Survey::find(1);
    //     $sample = $survey->samples()->first();
    //     $subjects = $sample->subjects->filter(function ($item) {
    //         if ($item->pivot->finished_at) return $item;
    //     });
    //
    //     $array = [];
    //     if ($subjects) foreach ($subjects as $subject){
    //         $answer = $subject->answers->where('question_id', 4)->first();
    //         if ($answer) foreach ($answer->options as $option) $array [$option->statement] [] = $subject->id;
    //     }
    //     return $array;
    // }

    return view('auth.login');
});
