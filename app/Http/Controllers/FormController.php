<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use App\Option;
use App\Subject;
use App\Answer;
use Illuminate\Http\Request;

class FormController extends Controller
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
    public function index(Survey $survey, Subject $subject)
    {
        $sample = $survey->has('samples')->first();

        if(!$sample)
            return redirect()->route('sample.create', ['id'=>$survey->id]);

        if($subject->id){
            $answers = Answer::where([['survey_id', $survey->id], ['subject_id', $subject->id]])->get();
            $questions = $survey->questions;

            return view('form.create', compact('survey','sample','subject','questions','answers'));
        }

        return view('form.index', compact('survey','sample'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $answers = [];
        if ($inputs = request('question'))
            foreach($inputs as $id => $input){
                $question = Question::findOrFail($id);

                switch($question->type){
                    case 1:
                        $answers [] = Option::findOrFail($input);
                    break;

                    case 2:
                        foreach ($input as $key => $option){
                            if ($key == 'other' && $other = ucfirst(trim($option))){
                                $question->options()->save($other = Option::create(['statement'=>$other]));
                                $answers [] = $other;
                            }

                            elseif($option)
                                $answers [] = Option::findOrFail($key);
                        }
                    break;

                    case 3:
                        $answers [] = $input;
                    break;

                    case 4:
                        $answers [] = $input;
                    break;

                    case 5:
                        $answers [] = $input;
                    break;

                    default:
                        dd($question->id . ': invalid question type.');
                    break;
                }
            }

        return $answers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
