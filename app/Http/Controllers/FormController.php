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
use Illuminate\Support\Facades\Route;

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

    public function login(Request $request, $token)
    {
        $data = json_decode(base64_decode($token), true);

        $survey = Survey::findOrFail($data['survey_id']);
        $sample = Sample::findOrFail($data['sample_id']);
        $subject = Subject::findOrFail($data['subject_id']);

        session([
            'survey' => $survey,
            'sample' => $sample,
            'subject' => $subject,
            'questions' => $survey->questions,
            'conditions' => $survey->conditions,
        ]);

        return view('direct.index', compact('survey', 'sample', 'subject'));
    }

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
                $answer = $question->answers()->where(['sample_id'=>$sample->id,'subject_id'=>$subject->id])->first();
                if (isset($answer)){
                    $checked_ids = $answer->options->pluck('id');
                    break;

                } else break;
            }
            return ['question' => $question, 'questions' => $questions, 'hide' => false];
        }

        return $this->jump($survey, $question, $sample, $subject);
    }

    private function jump(Survey $survey, Question $question, Sample $sample, Subject $subject) {
        $questions = $question->questions->keyBy('id');
        $whereIn = $question->questions->pluck('id');
        $whereIn [] = $question->id;

        if ($question->format == 3)
            $conditions = session('conditions')->whereIn('to_question_id', $whereIn)->where('to_option_id', null);
        else
            $conditions = session('conditions')->where('to_question_id', $question->id)->where('to_option_id', null);

        if (!count($conditions))
            return ['question' => $question, 'questions' => $questions, 'hide' => false];

        $only = [];
        foreach ($conditions as $condition) {
            $given_answer = Answer::where('question_id', $condition->question_id)
                ->where('sample_id', $sample->id)
                ->where('subject_id', $subject->id)
                ->first();

            if (isset($given_answer)){
                if (Route::currentRouteName() == 'form.previous') $order = $question->order -1;
                else $order = $question->order +1;

                if ($condition->show){
                    $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                    if ($condition_met){
                        $show =  session('questions')->where('id', $condition->to_question_id)->first();
                    } else {
                        $show = session('questions')->where('survey_id', $survey->id)->where('order', $order)->first();
                    }

                } else {
                    $condition_met = $given_answer->options()->where('id', $condition->option_id)->first();
                    if ($condition_met) {
                        $show = session('questions')->where('survey_id', $survey->id)->where('order', $order)->first();
                    } else {
                        $show = session('questions')->where('id', $condition->to_question_id)->first();
                    }
                }

                if(isset($show) && $question->format == 3) {
                    $only [] = $show->id;
                    continue;
                }
                elseif(isset($show)){
                    if ($question == $show){
                        return ['question' => $question, 'questions' => null, 'hide' => false];
                    } else
                        return $this->jump($survey, $show, $sample, $subject);
                }

            } else {
                if (Route::currentRouteName() == 'form.previous') $order = $question->order -1;
                else $order = $question->order +1;
                $show = session('questions')->where('survey_id', $survey->id)->where('order', $order)->first();
                return $this->jump($survey, $show, $sample, $subject);
            }
        }

        if (isset($only[0])){
            $hide = !in_array($question->id,$only) ? true : false;

            foreach ($questions as $key => $value)
                if (!in_array($value->id,$only))
                    $questions->forget($value->id);
        }

        $hide = isset($hide) ? $hide: false;
        return ['question' => $question, 'questions' => $questions, 'hide' => $hide];
    }

    public function next(Request $request)
    {
        $survey = session('survey');
        $sample = session('sample');
        $subject = session('subject');

        if (request('next') != null) $previous = session('questions')->where('order',request('next')-1)->first();
        if (request('next') != null) $question = session('questions')->where('order',request('next'))->first();

        // if (Route::currentRouteName() == 'form.next' && !$this->store($request)){
        //     $previous = session('questions')->where('order',request('next')-2)->first();
        //     $question = session('questions')->where('order',request('next')-1)->first();
        //     $request->session()->flash('errors', ['Por favor, responda a pergunta para prosseguir']);
        // } else
        //     $request->session()->forget('errors');
        if(!$this->store($request))
            $request->session()->flash('errors', ['Por favor, preencha a pergunta anterior antes de prosseguir']);
        else $request->session()->forget('errors');

        if(isset($question)){
            $currents = $this->current($request, $question);
            $question = $currents['question'];
            $questions = $currents['questions'];
            $hide = $currents['hide'] ? true : false;
            unset($currents);

            $answer = $question->answers()->where(['sample_id'=>$sample->id,'subject_id'=>$subject->id])->first();

            $checked_ids = [];
            $text_values = [];

            if (isset($answer) && $question->format == "3"){
                foreach($answer->options as $given){
                    $checked_ids [$question->id] [] = $given->id;

                    if ($question->type == 3 || $question->type == 4 || $question->type == 5){
                        $text_values [$question->id] [$given->id] = $given->pivot->value;
                    }

                    foreach ($question->questions as $collumn){
                        $colAnswer = Answer::where(['subject_id'=>$subject->id, 'sample_id'=>$sample->id,'question_id'=>$collumn->id])->first();
                        if(isset($colAnswer))
                            if (count($collumn->options)){
                                $text = $colAnswer->options()->where('option_id', $given->id)->get();
                                foreach ($text as $subKey => $subCollumn) {
                                    $text_values [$collumn->id] [$given->id] [$subCollumn->pivot->sub_option_id] = $subCollumn->pivot->value;
                                }
                            } else
                                foreach($colAnswer->options as $given) {
                                    $checked_ids [$collumn->id] [] = $given->id;
                                    if ($collumn->type == 3 || $collumn->type == 4 || $collumn->type == 5)
                                        $text_values [$collumn->id] [$given->id] = $given->pivot->value;
                                }
                    }
                }
            }
            elseif(isset($answer) && $question->format != 3) foreach($answer->options as $given){
                $checked_ids [] = $given->id;
                if ($question->type == 3)
                    $text_values [$given->id] = $given->pivot->value;
                if ($question->type == 4 || $question->type == 5)
                    $text_values [$given->id] = $given->pivot->value;
            }

        } else {
            $finish = Carbon::now();
            $sample->subjects()->where('subject_id', $subject->id)->updateExistingPivot($subject->id, ['finished_at' => $finish,'user_id' => \Auth::user()->id]);

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

        return view('form.create', compact('survey','sample','subject','previous','questions','question','hide','options','suboptions','answer','checked_ids','text_values'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = request('question');
        $refuseds = request('refused');
        $dontknows = request('dontknow');

        $errors = [];
        if (!empty($inputs)) foreach ($inputs as $k => $v){
            if (is_null($v) && !isset($refuseds[$k]) && !isset($dontknows[$k])){
                $request->session()->push('errors', 'Por favor, preencha todos os campos para prosseguir');
                $errors [] = 'Por favor, preencha todos os campos para prosseguir'; break;
            }
            if (is_array($v)) foreach ($v as $kk => $vv){
                if (is_null($vv) && !isset($refuseds[$k]) && !isset($dontknows[$k])){
                    $request->session()->push('errors', 'Por favor, preencha todos os campos para prosseguir');
                    $errors [] = 'Por favor, preencha todos os campos para prosseguir'; break;
                }
                if (is_array($vv)) foreach ($vv as $kkk => $vvv){
                    if (is_null($vvv)){
                        $request->session()->push('errors', 'Por favor, preencha todos os campos para prosseguir');
                        $errors [] = 'Por favor, preencha todos os campos para prosseguir'; break;
                    }
                }
            }
        }

        if (!empty($errors))
            return false;

        $others = [];
        $questions = [];
        $unnamed_other = [];
        if ($inputs_others = request('other'))
            foreach ($inputs_others as $k => $v)
                if (is_numeric($k)){
                    if (!isset($questions[$k]))
                        $questions [$k] = session('questions')->where('id', $k)->first();
                    if (ucfirst(trim($v))){
                        $others [$k] = Option::create(['statement'=>ucfirst(trim($v))]);
                        $questions[$k]->options()->save($others[$k]);
                    }
                } else
                    $unnamed_other [] = $inputs_others[$k];

        if (!$inputs && empty($others) && !$refuseds && !$dontknows && !request('init'))
            return false;

        if (!empty($inputs)) foreach ($inputs as $id => $input)
            $questions [$id] = session('questions')->where('id', $id)->first();

        if (!empty($refuseds)) foreach ($refuseds as $id => $input)
            $questions [$id] = session('questions')->where('id', $id)->first();

        if (!empty($dontknows)) foreach ($dontknows as $id => $input)
            $questions [$id] = session('questions')->where('id', $id)->first();

        if (!empty($unnamed_other))
            foreach ($unnamed_other as $key => $value)
                foreach ($value as $k => $v) {
                    if (!isset($questions[$k]))
                        $questions [$k] = session('questions')->where('id', $k)->first();
                }

        foreach($questions as $question){
            if (isset($inputs[$question->id]))
                $input = $inputs[$question->id];
            else $input = [];

            $refused = isset($refuseds[$question->id]) ? $refuseds[$question->id] : false;
            $dontknow = isset($dontknows[$question->id]) ? $dontknows[$question->id] : false;

            $answer = Answer::firstOrCreate([
                'sample_id' => session('sample_id'),
                'subject_id' => session('subject_id'),
                'question_id' => $question->id,
            ], ['user_id' => \Auth::user()->id]);

            $answer->refused = $refused;
            $answer->dontknow = $dontknow;
            $answer->save();

            switch($question->type){
                case 1: $this->storeUnique($request, $question, $answer, $input, $others); break;
                case 2: $this->storeMultiple($request, $question, $answer, $input, $others); break;
                case 3: $this->storeOpen($request, $question, $answer, $input, $others); break;
                case 4: $this->storeOrdering($request, $question, $answer, $input, $others); break;
                case 5: $this->storeGrade($request, $question, $answer, $input, $others); break;

                default: dd($question->id . ': invalid question type.'); break;
            }
        }

        return true;
    }

    public function storeUnique(Request $request, Question $question, Answer $answer, $input, $others)
    {
        $selectedOption = null;
        if (!empty($others)) foreach ($others as $k => $v)
            $selectedOption = $v;

        elseif ($input && is_numeric($input))
            $selectedOption = Option::findOrFail($input);

        if ($selectedOption) $answer->options()->sync([$selectedOption->id]);
        return $answer;
    }

    public function storeMultiple(Request $request, Question $question, Answer $answer, $input, $others)
    {
        $selectedOptions = [];
        foreach ($input as $key => $option)
            if ($key && is_numeric($key) && $option)
                $selectedOptions [] = Option::findOrFail($key);

        if (!empty($others)) foreach ($others as $k => $v)
            $selectedOptions [] = $v;

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
        foreach ($input as $key => $option){
            if (is_array($option))
                foreach($option as $subKey => $subOption)
                    $answer->options()->attach([$key => ['sub_option_id' => $subKey, 'value' => $subOption]]);
            else
                $answer->options()->attach([$key => ['value' => $option]]);
        }

        if (!empty($others)) foreach ($others as $k => $v){
            $other = request('other');
            $other_grade = $other['grade'];
            $answer->options()->attach([$v->id => ['value' => $other_grade[$question->id] ]]);
        }

        return $answer;
    }

}
