<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use App\Option;
use App\Sample;
use App\Subject;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

            return view('form.show', compact('survey','sample','subject','questions','answers'));
        }

        return view('form.index', compact('survey','sample'));
    }

    public function current()
    {
        $survey = Survey::find(session('survey_id'));
        $sample = Sample::find(session('sample_id'));
        $subject = Subject::find(session('subject_id'));

        $questions = $survey->questions;
        $answers = Answer::whereIn('question_id', $questions->pluck('id')->toArray())->where('subject_id', $subject->id)->get();

        foreach ($questions as $question){
            if ($answer = $question->has('answer')->first()){
                $answer = $question->answer;
                $checked_ids = [];
                if(isset($answer)) foreach($answer->options as $given)
                    $checked_ids [] = $given->id;
                break;
            }
            else
                break;
        }

        return view('krones.create', compact('survey','sample','subject','question','answer','checked_ids'));
    }

    public function next(Request $request)
    {
        $survey = Survey::find(session('survey_id'));
        $sample = Sample::find(session('sample_id'));
        $subject = Subject::find(session('subject_id'));

        if ($last_question = $this->store($request)){
            $pre = request('previous');
            if ($pre==8)
                $previous = Question::where('order',3)->first();
            elseif ($pre==13)
                $previous = Question::where('order',12)->first();
            elseif ($pre==15)
                $previous = Question::where('order',14)->first();
            elseif ($pre==17)
                $previous = Question::where('order',16)->first();
            elseif ($pre==19)
                $previous = Question::where('order',18)->first();
            elseif ($pre==21)
                $previous = Question::where('order',20)->first();
            elseif ($pre==23)
                $previous = Question::where('order',22)->first();
            elseif ($pre==25)
                $previous = Question::where('order',24)->first();
            elseif ($pre==27)
                $previous = Question::where('order',26)->first();
            elseif ($pre==30)
                $previous = Question::where('order',29)->first();
            elseif ($pre==38)
                $previous = Question::where('order',33)->first();
            else
                $previous = Question::where('order',$pre)->first();


            $next = request('next');
            if ($next==3)
                $question = Question::where('order',9)->first();
            elseif ($next==12)
                $question = Question::where('order',13)->first();
            elseif ($next==14)
                $question = Question::where('order',15)->first();
            elseif ($next==16)
                $question = Question::where('order',17)->first();
            elseif ($next==18)
                $question = Question::where('order',19)->first();
            elseif ($next==20)
                $question = Question::where('order',21)->first();
            elseif ($next==22)
                $question = Question::where('order',23)->first();
            elseif ($next==24)
                $question = Question::where('order',25)->first();
            elseif ($next==26)
                $question = Question::where('order',27)->first();
            elseif ($next==29)
                $question = Question::where('order',30)->first();
            elseif ($next==33)
                $question = Question::where('order',38)->first();
            else
                $question = Question::where('order',$next)->first();
        }

        if(isset($question)){
            $answer = $question->answer;
            $checked_ids = [];
            $text_values = [];
            if(isset($answer)) foreach($answer->options as $given){
                $checked_ids [] = $given->id;

                if ($question->type == 3){
                    $text = DB::table('answer_option')->select('value')
                        ->where(['answer_id' => $answer->id])
                        ->where(['option_id' => $given->id])
                        ->first();
                    $text_values [$given->id] = $text->value;
                }
            }

        } else {
            $finish = Carbon::now();
            DB::table('sample_subject')
                ->where(['sample_id' => $sample->id], ['subject_id' => $subject->id])
                ->update(['finished_at' => $finish]);

            return view('krones.finish', compact('finish','survey'));
        }

        return view('krones.create', compact('survey','sample','subject','previous','question','answer','checked_ids','text_values'));
    }

    public function previous(Question $question)
    {
        $survey = Survey::find(session('survey_id'));
        $sample = Sample::find(session('sample_id'));
        $subject = Subject::find(session('subject_id'));

        $previous = Question::where('order',$question->order -1)->first();

        $answer = $question->answer;
        $checked_ids = [];
        $text_values = [];
        if(isset($answer)) foreach($answer->options as $given){
            $checked_ids [] = $given->id;
            if ($question->type == 3){
                $text = DB::table('answer_option')->select('value')
                    ->where(['answer_id' => $answer->id])
                    ->where(['option_id' => $given->id])
                    ->first();
                $text_values [$given->id] = $text->value;
            }
        }

        return view('krones.create', compact('survey','sample','subject','previous','question','answer','checked_ids','text_values'));
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

        return true;
    }

}
