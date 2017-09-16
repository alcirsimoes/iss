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

            return view('form.show', compact('survey','sample','subject'));
        }

        return view('form.index', compact('survey','sample'));
    }

    private function current(Request $request, Question $question)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        $question->load('questions');

        if ($request->input('init')){
            $questions = session('questions');

            foreach ($questions as $question){
                $answer = $question->answer()->where('subject_id',$subject->id)->first();
                if (isset($answer)){
                    $checked_ids = $answer->options->pluck('id');
<<<<<<< HEAD
                    break;

                } else break;
=======
                    break;

                } else
                    break;
>>>>>>> 4ebd4fafacee8ecc4cfc0d89e6639b6f74265acc
            }
            return ['question' => $question, 'questions' => $questions];
        }

        function jump(Survey $survey, Question $question, Sample $sample, Subject $subject) {
            $questions = $question->questions->keyBy('id');

            if ($question->format == 3)
                $conditions = session('conditions')->whereIn('to_question_id', $question->questions->pluck('id'))->where('to_option_id', null);
            else
                $conditions = session('conditions')->where('to_question_id', $question->id)->where('to_option_id', null);

            if (!count($conditions))
                return ['question' => $question, 'questions' => $questions];

            $only = [];
            foreach ($conditions as $condition) {
                $given_answer = Answer::where('question_id', $condition->question_id)
                    ->where('sample_id', $sample->id)
                    ->where('subject_id', $subject->id)
                    ->first();

                if (isset($given_answer)){
                    if ($condition->show){
                        $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                        if ($condition_met){
                            $show = Question::find($condition->to_question_id);
                            // return jump($survey, $question, $sample, $subject);
                        } else {
                            $show = Question::where('survey_id', $survey->id)->where('order', $question->order +1)->first();
                            // return jump($survey, $question, $sample, $subject);
                        }

                    } else {
                        $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                        if ($condition_met) {
                            $show = Question::where('survey_id', $survey->id)->where('order', $question->order +1)->first();
                            // return jump($survey, $question, $sample, $subject);
                        } else {
                            $show = Question::find($condition->to_question_id);
                            // return jump($survey, $question, $sample, $subject);
                        }
                    }

                    if(isset($show) && $question->format == 3) {
                        $only [] = $show->id;
                        continue;
                    }
                    elseif(isset($show)){
                        $question = $show;
                        return ['question' => $question, 'questions' => null];
                    }
                }
            }

            if (isset($only[0])){
                foreach ($questions as $key => $value)
                    if (!in_array($value->id,$only))
                        $questions->forget($value->id);
            }

            return ['question' => $question, 'questions' => $questions];
        }

        return jump($survey, $question, $sample, $subject);
    }

    public function next(Request $request)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        $this->store($request);

        if (request('previous') != null) $previous = Question::where('order',request('previous'))->first();
        if (request('next') != null) $question = Question::where('order',request('next'))->first();

        if(isset($question)){
            $currents = $this->current($request, $question);
            $question = $currents['question'];
            $questions = $currents['questions'];
            unset($currents);

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
                ->update([
                    'finished_at' => $finish,
                    'user_id' => \Auth::user()->id,
                ]);

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

        if (count($questions)){
            $suboptions = [];
            foreach ($questions as $subquestion){
                $conditions = session('conditions')->where('to_question_id', $subquestion->id);
                $suboptions [$subquestion->id] = $subquestion->options;
                if (count($conditions)) {
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
                                $suboptions[$subquestion->id]->except($condition->to_option_id);
                            }
                        }
                    }
                    if (isset($only[0])){
                        $suboptions[$subquestion->id] = $suboptions[$subquestion->id]->keyBy('id');
                        foreach ($suboptions[$subquestion->id] as $key => $value)
                            if (!in_array($value->id,$only))
                                $suboptions[$subquestion->id]->forget($value->id);
                    }
                }
            }
        }

        return view('form.create', compact('survey','sample','subject','previous','questions','question','options','suboptions','answer','checked_ids','text_values'));
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

        return view('form.create', compact('survey','sample','subject','previous','questions','question','options','suboptions','answer','checked_ids','text_values'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$inputs = request('question'))
            return;


        $others = [];
        $questions = [];
        $unamed_other = [];
        foreach ($inputs as $id => $input)
            $questions [$id] = Question::findOrFail($id);

        if ($inputs_others = request('other'))
            foreach ($inputs_others as $k => $v)
                if (is_numeric($k)){
                    if (!isset($questions[$k]))
                        $questions [$k] = Question::findOrFail($k);
                    if (ucfirst(trim($v)))
                        $others [$k] = Option::create(['statement'=>ucfirst(trim($v))]);
                } else
                    $unamed_other [] = $inputs_others[$k];

        if (!empty($unamed_other))
            foreach ($unamed_other as $key => $value)
                foreach ($value as $k => $v) {
                    if (!isset($questions[$k]))
                        $questions [$k] = Question::findOrFail($k);
                    if ($v) $questions[$k]->options()->save($others[$k]);
                }


        foreach($questions as $question){
            if (isset($inputs[$question->id]))
                $input = $inputs[$question->id];

            $answer = Answer::firstOrCreate([
                'sample_id' => session('sample_id'),
                'subject_id' => session('subject_id'),
                'question_id' => $question->id,
            ], ['user_id' => \Auth::user()->id]);

            switch($question->type){
                case 1: $this->storeUnique($request, $question, $answer, $input, $others); break;
                case 2: $this->storeMultiple($request, $question, $answer, $input, $others); break;
                case 3: $this->storeOpen($request, $question, $answer, $input, $others); break;
                case 4: $this->storeOrdering($request, $question, $answer, $input, $others); break;
                case 5: $this->storeGrade($request, $question, $answer, $input, $others); break;

                default: dd($question->id . ': invalid question type.'); break;
            }
        }

    }

    public function storeUnique(Request $request, Question $question, Answer $answer, $input, $others)
    {
        if (isset($others[$question->id]) && $other_option = $others[$question->id])
            $selectedOption = $other_option;

        elseif ($input && is_numeric($input))
            $selectedOption = Option::findOrFail($input);

        $answer->options()->sync([$selectedOption->id]);
        return $answer;
    }

    public function storeMultiple(Request $request, Question $question, Answer $answer, $input, $others)
    {
        $selectedOptions = [];
        foreach ($input as $key => $option){
            if ($key && is_numeric($key) && $option)
                $selectedOptions [] = Option::findOrFail($key);

            elseif ($question->other)
                return;
        }

        $answer->options()->sync(collect($selectedOptions)->pluck('id'));
        return $answer;
    }

    public function storeOpen(Request $request, Question $question, Answer $answer, $input, $others)
    {
        if (is_array($input)){
            $answer->options()->detach();
            foreach ($input as $key => $option)
                $answer->options()->attach([$key => ['value' => $option]]);

        } elseif ($given = trim($input)) {
            $answer->value = $given;
            $answer->save();
        }

        return $answer;
    }

    public function storeOrdering(Request $request, Question $question, Answer $answer, $input, $others)
    {
        foreach (range(1,count($input)) as $v)
            if (!in_array($v, $input))
                return 'not valid';

        $answer->options()->detach();
        foreach ($input as $key => $option)
            $answer->options()->attach([$key => ['value' => $option]]);

        return $answer;
    }

    public function storeGrade(Request $request, Question $question, Answer $answer, $input, $others)
    {
        $answer->options()->detach();
        DB::table('answer_option_option')
            ->where('answer_id', $answer->id)
            ->delete();

        foreach ($input as $key => $option){
            if (is_array($option)){
                foreach($option as $subKey => $subOption)
                    DB::table('answer_option_option')->insert([
                        'answer_id' => $answer->id,
                        'option_id' => $key,
                        'sub_option_id' => $subKey,
                        'value' => $subOption
                    ]);

            } else
                $answer->options()->attach([$key => ['value' => $option]]);
        }

        return $answer;
    }

}
