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
    public function index(Request $request, Survey $survey, Subject $subject)
    {
        $sample = $survey->samples->first();

        if(!$sample)
            return redirect()->route('sample.create', ['id'=>$survey->id]);

        if($subject->id){
            $questions = $survey->questions;
            $answers = Answer::whereIn('question_id', $questions->pluck('id')->toArray())->where('subject_id', $subject->id)->get();

            session([
                'survey_id' => $survey->id,
                'sample_id' => $sample->id,
                'subject_id' => $subject->id,
                'survey' => $survey,
                'sample' => $sample,
                'subject' => $subject,
                'questions' => $survey->questions,
                'conditions' => $survey->conditions,
            ]);

            return view('form.show', compact('survey','sample','subject','questions','answers'));
        }

        return view('form.index', compact('survey','sample'));
    }

    private function current(Request $request, Question $question)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        if ($request->input('init')){
            $questions = session('questions');
            $answers = Answer::whereIn('question_id', $questions->pluck('id')->toArray())->where('subject_id', $subject->id)->get();

            foreach ($questions as $question){
                $answer = $question->answer()->where('subject_id',$subject->id)->first();
                if (isset($answer)){
                    $checked_ids = [];
                    if(isset($answer)) foreach($answer->options as $given)
                    $checked_ids [] = $given->id;
                    break;
                }
                else
                break;
            }
            return $question;
        }

        function jump(Survey $survey, Question $question, Sample $sample, Subject $subject) {
            $conditions = session('conditions')->where('to_question_id', $question->id)->where('to_option_id', null);
            if (!count($conditions))
                return $question;

            foreach ($conditions as $condition) {
                $given_answer = Answer::where('question_id', $condition->question_id)
                    ->where('sample_id', $sample->id)
                    ->where('subject_id', $subject->id)
                    ->first();

                if (isset($given_answer)){
                    if ($condition->show){
                        $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                        if ($condition_met){
                            $question = Question::find($condition->to_question_id);
                            // return jump($survey, $question, $sample, $subject);
                        } else {
                            $question = Question::where('survey_id', $survey->id)->where('order', $question->order +1)->first();
                            // return jump($survey, $question, $sample, $subject);
                        }

                    } else {
                        $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                        if ($condition_met) {
                            $question = Question::where('survey_id', $survey->id)->where('order', $question->order +1)->first();
                            // return jump($survey, $question, $sample, $subject);
                        } else {
                            $question = Question::find($condition->to_question_id);
                            // return jump($survey, $question, $sample, $subject);
                        }
                    }
                }
            }

            return $question;
        }

        return jump($survey, $question, $sample, $subject);
    }

    public function next(Request $request)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        if ($last_question = $this->store($request)){
            $previous = Question::where('order',request('previous'))->first();
            $question = Question::where('order',request('next'))->first();
        }

        if(isset($question)){
            $question = $this->current($request, $question);

            $answer = $question->answer()->where('subject_id',$subject->id)->first();

            $checked_ids = [];
            $text_values = [];

            if (isset($answer) && $question->format == "3"){
                foreach($answer->options as $given){
                    $checked_ids [$question->id] [] = $given->id;

                    if ($question->type == 3 || $question->type == 4 || $question->type == 5){
                        $text = DB::table('answer_option')->select('value')
                            ->where(['answer_id' => $answer->id])
                            ->where(['option_id' => $given->id])
                            ->first();
                        $text_values [$question->id] [$given->id] = $text->value;
                    }
                    foreach ($question->questions as $collumn){
                        $colAnswer = $collumn->answer;

                        if(isset($colAnswer)) {
                            if ($collumn->options){
                                $text = DB::table('answer_option_option')->select('value','sub_option_id')
                                ->where(['answer_id' => $colAnswer->id])
                                ->where(['option_id' => $given->id])
                                ->get();
                                foreach ($text as $subKey => $subCollumn){
                                    $text_values [$collumn->id] [$given->id] [$subCollumn->sub_option_id] = $subCollumn->value;
                                }
                            }
                        }
                    }
                }

                foreach ($question->questions as $collumn){
                    $col_answer = $collumn->answer;

                    if(isset($col_answer)) {
                        foreach($col_answer->options as $given){
                            $checked_ids [$collumn->id] [] = $given->id;

                            if ($collumn->type == 3 || $collumn->type == 4 || $collumn->type == 5){
                                $text = DB::table('answer_option')->select('value')
                                ->where(['answer_id' => $col_answer->id])
                                ->where(['option_id' => $given->id])
                                ->first();
                                $text_values [$collumn->id] [$given->id] = $text->value;
                            }
                        }
                    }
                }
            }
            elseif(isset($answer) && $question->format != 3) foreach($answer->options as $given){
                $checked_ids [] = $given->id;

                if ($question->type == 3 || $question->type == 4 || $question->type == 5){
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

            return view('form.finish', compact('finish','survey'));
        }

        $conditions = session('conditions')->where('to_question_id', $question->id);
        if (!count($conditions)) {
            $options = $question->options;
        } else {
            $options = $question->options;
            $given_answers = Answer::whereIn('question_id', $conditions->pluck('question_id'))
                ->where('sample_id', $sample->id)
                ->where('subject_id', $subject->id)
                ->get();

            $only = [];
            foreach ($conditions as $condition) {
                $given_answer = $given_answers->where('question_id', $condition->question_id)->first();

                if (isset($given_answer)){
                    $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();

                    if ($condition->show){
                        if ($condition_met)
                            $only [] = $condition->to_option_id;
                    } else {
                        if ($condition_met)
                            $options->except($condition->to_option_id);
                    }
                }
            }
            if (isset($only[0])){
                $options = $options->keyBy('id');
                foreach ($options as $key => $value)
                    if (!in_array($value->id,$only))
                        $options->forget($value->id);
            }
        }

        return view('form.create', compact('survey','sample','subject','previous','question','options','answer','checked_ids','text_values'));
    }

    public function previous(Question $question)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        $previous = Question::where('order',$question->order -1)->first();

        if(isset($question)){
            $answer = $question->answer;
            $checked_ids = [];
            $text_values = [];

            if (isset($answer) && $question->format == "3"){
                foreach($answer->options as $given){
                    $checked_ids [$question->id] [] = $given->id;

                    if ($question->type == 3 || $question->type == 4 || $question->type == 5){
                        $text = DB::table('answer_option')->select('value')
                            ->where(['answer_id' => $answer->id])
                            ->where(['option_id' => $given->id])
                            ->first();
                        $text_values [$question->id] [$given->id] = $text->value;
                    }
                    foreach ($question->questions as $collumn){
                        $colAnswer = $collumn->answer;

                        if(isset($colAnswer)) {
                            if ($collumn->options){
                                $text = DB::table('answer_option_option')->select('value','sub_option_id')
                                ->where(['answer_id' => $colAnswer->id])
                                ->where(['option_id' => $given->id])
                                ->get();
                                foreach ($text as $subKey => $subCollumn){
                                    $text_values [$collumn->id] [$given->id] [$subCollumn->sub_option_id] = $subCollumn->value;
                                }
                            }
                        }
                    }
                }

                foreach ($question->questions as $collumn){
                    $col_answer = $collumn->answer;

                    if(isset($col_answer)) {
                        foreach($col_answer->options as $given){
                            $checked_ids [$collumn->id] [] = $given->id;

                            if ($collumn->type == 3 || $collumn->type == 4 || $collumn->type == 5){
                                $text = DB::table('answer_option')->select('value')
                                ->where(['answer_id' => $col_answer->id])
                                ->where(['option_id' => $given->id])
                                ->first();
                                $text_values [$collumn->id] [$given->id] = $text->value;
                            }
                        }
                    }
                }
            }
            elseif(isset($answer) && $question->format != 3) foreach($answer->options as $given){
                $checked_ids [] = $given->id;

                if ($question->type == 3 || $question->type == 4 || $question->type == 5){
                    $text = DB::table('answer_option')->select('value')
                        ->where(['answer_id' => $answer->id])
                        ->where(['option_id' => $given->id])
                        ->first();
                    $text_values [$given->id] = $text->value;
                }
            }

        }

        $conditions = session('conditions')->where('to_question_id', $question->id);
        if (!count($conditions)) {
            $options = $question->options;
        } else {
            $options = $question->options;
            $given_answers = Answer::whereIn('question_id', $conditions->pluck('question_id'))
                ->where('sample_id', $sample->id)
                ->where('subject_id', $subject->id)
                ->get();

            $only = [];
            foreach ($conditions as $condition) {
                $given_answer = $given_answers->where('question_id', $condition->question_id)->first();

                if (isset($given_answer)){
                    $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();

                    if ($condition->show){
                        if ($condition_met)
                            $only [] = $condition->to_option_id;
                    } else {
                        if ($condition_met)
                            $options->except($condition->to_option_id);
                    }
                }
            }
            
            if (isset($only[0])){
                $options = $options->keyBy('id');
                foreach ($options as $key => $value)
                    if (!in_array($value->id,$only))
                        $options->forget($value->id);
            }
        }

        return view('form.create', compact('survey','sample','subject','previous','question','options','answer','checked_ids','text_values'));
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
                        $answers [] = $this->storeUnique($request, $question, $input);
                    break;

                    case 2:
                        $answers [] = $this->storeMultiple($request, $question, $input);
                    break;

                    case 3:
                        $answers [] = $this->storeOpen($request, $question, $input);
                    break;

                    case 4:
                        $answers [] = $this->storeOrdering($request, $question, $input);
                    break;

                    case 5:
                        $answers [] = $this->storeGrade($request, $question, $input);
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

                            else //if ($request->input('question.'.$id) == 'empty')
                                return 346;
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
                        if ($other = ucfirst(trim($input))){
                            // $selectedOption = $question->options()->orderBy('created_at', 'desc')->first();
                            $selectedOption = $question;
                            $question->options()->save($selectedOption = Option::create(['statement'=>$other]));
                        }

                        else //if ($request->input('question.'.$id) == 'empty')
                            return 372;

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

                    case 3:

                    break;
                    case 4:

                    break;
                    case 5:
                    break;

                    default:
                        dd($question->id . ': invalid question type.');
                    break;
                }
            }

        return true;
    }

    public function storeUnique(Request $request, Question $question, $input)
    {
        if ($input && is_numeric($input))
            $selectedOption = Option::findOrFail($input);

        elseif ($question->other)
            return;

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
        return $answer;
    }

    public function storeMultiple(Request $request, Question $question, $input)
    {
        $selectedOptions = [];
        foreach ($input as $key => $option){
            if ($key && is_numeric($key) && $option)
                $selectedOptions [] = Option::findOrFail($key);

            elseif ($question->other)
                return;
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
        return $answer;
    }

    public function storeOpen(Request $request, Question $question, $input)
    {
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

        return $answer;
    }

    public function storeOrdering(Request $request, Question $question, $input)
    {
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

        return $answer;
    }

    public function storeGrade(Request $request, Question $question, $input)
    {
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

        $answer->options()->detach();
        DB::table('answer_option_option')
            ->where('answer_id', $answer->id)
            ->delete();
        foreach ($input as $key => $option){
            if (is_array($option)){
                foreach($option as $subKey => $subOption){
                    DB::table('answer_option_option')->insert([
                        'answer_id' => $answer->id,
                        'option_id' => $key,
                        'sub_option_id' => $subKey,
                        'value' => $subOption
                    ]);
                }
            }
            else {
                DB::table('answer_option')->insert([
                    'answer_id' => $answer->id,
                    'option_id' => $key,
                    'value' => $option
                ]);
            }
        }

        return $answer;
    }

}
