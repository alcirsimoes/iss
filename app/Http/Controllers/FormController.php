<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use App\Option;
use App\Subject;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $questions = $survey->questions;
            $answers = Answer::whereIn('question_id', $questions->pluck('id')->toArray())->where('subject_id', $subject->id)->get();

            session([
                'survey_id' => $survey->id,
                'sample_id' => $sample->id,
                'subject_id' => $subject->id
            ]);

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
                        if ($input && is_numeric($input))
                            $selectedOption = Option::findOrFail($input);

                        elseif ($question->other)
                            break;

                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id
                            ]);

                        $answer->options()->sync([$selectedOption->id]);
                        $answers [] = $answer;
                    break;

                    case 2:
                        $selectedOptions = [];
                        foreach ($input as $key => $option){
                            if ($key && is_numeric($key) && $option)
                                $selectedOptions [] = Option::findOrFail($key);

                            elseif ($question->other)
                                return $input;
                        }

                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id
                            ]);

                        $ids = [];
                        foreach ($selectedOptions as $selectedOption)
                            $ids [] = $selectedOption->id;

                        $answer->options()->sync($ids);
                        $answers [] = $answer;
                    break;

                    case 3:
                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id,
                            ]);

                        if (is_array($input)){
                            $answer->options()->detach();
                            foreach ($input as $key => $option){
                                DB::table('answer_option')->insert([
                                    'answer_id' => $answer->id,
                                    'option_id' => $key,
                                    'value' => $option
                                ]);
                            }
                        }
                        else {
                            if ($given = trim($input)){
                                $answer->value = $given;
                                $answer->save();
                            }
                        }

                        $answers [] = $answer;
                    break;

                    case 4:
                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id,
                            ]);

                        foreach (range(1,count($input)) as $v)
                            if (!in_array($v, $input))
                                return 'not valid';

                        $answer->options()->detach();
                        foreach ($input as $key => $option)
                            DB::table('answer_option')->insert([
                                'answer_id' => $answer->id,
                                'option_id' => $key,
                                'value' => $option
                            ]);

                        $answers [] = $input;
                    break;

                    case 5:
                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id,
                            ]);

                        // foreach ($input as $v)
                        //     if (!$v)
                        //         return 'not valid';

                        $answer->options()->detach();
                        foreach ($input as $key => $option)
                            DB::table('answer_option')->insert([
                                'answer_id' => $answer->id,
                                'option_id' => $key,
                                'value' => $option
                            ]);

                        $answers [] = $input;
                    break;

                    default:
                        dd($question->id . ': invalid question type.');
                    break;
                }
            }

        if ($others = request('other'))
            foreach($others as $id => $input){
                $question = Question::findOrFail($id);

                switch($question->type){
                    case 1:
                        if ($question->other){
                            if ($other = ucfirst(trim($input)))
                                $question->options()->save($selectedOption = Option::create(['statement'=>$other]));

                            elseif ($request->input('question.'.$id) == 'empty')
                                break;
                        }

                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id
                            ]);

                        $answer->options()->sync([$selectedOption->id]);
                        $answers [] = $answer;
                    break;

                    case 2:
                        if ($question->other){
                            if ($other = ucfirst(trim($input)))
                                $question->options()->save($selectedOption = Option::create(['statement'=>$other]));

                            else //if ($request->input('question.'.$id) == 'empty')
                                break;
                        }

                        $answer = Answer::where([
                            ['sample_id', session('sample_id')],
                            ['subject_id', session('subject_id')],
                            ['question_id', $question->id]
                        ])->first();

                        if (!$answer)
                            $answer = Answer::create([
                                'sample_id' => session('sample_id'),
                                'subject_id' => session('subject_id'),
                                'question_id' => $question->id
                            ]);

                        $answer->options()->attach($selectedOption->id);
                        $answers [] = $answer;
                    break;

                    default:
                        dd($question->id . ': invalid question type.');
                    break;
                }
            }

        return $answers;
    }

}
