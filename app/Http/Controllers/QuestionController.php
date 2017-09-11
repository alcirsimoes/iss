<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use App\Option;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return view('question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $survey = Survey::findOrFail(request('id'));
        return view('question.create')->with(compact('survey'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|max:255',
            'statement' => 'required'
        ]);

        $question = Question::create($request->all());

        $collumns = [];
        $collumnType = request('collumnType');
        $collumnStatement = request('collumnStatement');
        foreach(request('collumn') as $ck => $cv) {
            if ($cv) {
                $collumns [] = Question::create(['survey_id'=>request('survey_id'), 'name'=>$cv, 'statement'=>$collumnStatement[$ck], 'type'=>$collumnType[$ck]]);
                $collumnsOptions = [];
                if (request('collumnOption'.$ck)) foreach(request('collumnOption'.$ck) as $cok => $cov)
                    if ($cov) $collumnsOptions[] = Option::create(['statement' => $cov, 'value' => $cok]);

                if (isset($collumnsOptions[0])) $collumns[$ck]->options()->saveMany($collumnsOptions);
            }

        }

        $options = [];
        foreach(request('option') as $ok => $ov)
            if ($ov) $options[] = Option::create(['statement' => $ov, 'value' => $ok]);

        if (isset($options[0])) $question->options()->saveMany($options);

        if (isset($collumns[0])) {
            $question->questions()->saveMany($collumns);

            if (isset($collumnsOptions[0])) foreach($collumns as $ck => $cv)
                if (isset($options[0])) $cv->options()->saveMany($options);
        }

        return redirect()->route('survey.show', request('survey_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return $question->options;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'statement' => 'required'
        ]);

        $question = $question->fill($request->input());
        $question->saveOrFail();

        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return back();
    }
}
