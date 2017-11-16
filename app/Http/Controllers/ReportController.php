<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Survey;
use App\Question;
use App\Sample;
use App\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
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


    public function index(Survey $survey)
    {
        return view('report.index', compact('survey'));
    }

    public function list(Survey $survey, Sample $sample)
    {
        return view('report.list', compact('survey', 'sample'));
    }

    public function view(Survey $survey, Sample $sample, Subject $subject)
    {
        $answers = Answer::where(['sample_id'=>$sample->id, 'subject_id'=>$subject->id])->orderBy('question_id')->get();

        return view('report.view', compact('survey', 'sample', 'subject', 'answers'));
    }

    public function report(Survey $survey, Sample $sample)
    {
        $questions = $survey->questions;
        $answers = Answer::with('options','subject')->where('sample_id', $sample->id)->get();
        $answers->filter(function($item){
            return is_null($item->subject->deleted_at);
        });

        $processamento = [];
        foreach($questions as $question){
            if ($question->type == 1){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                foreach($question->options as $option){
                    $filtered = Answer::withCount(['options' => function ($query) use($option) {
                        $query->where('id', $option->id);}])->where('question_id', $question->id)->get();
                    $respostas [$option->statement] = $filtered->sum('options_count');
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $porcentagens = [];
                foreach ($respostas as $k => $v){
                    if ($k != 'Total' && $respostas ['Total'] > 0)
                        $porcentagens [$k] = ($v / $respostas ['Total']) * 100;
                }

                $processamento [$question->id] = ['respostas' => $respostas, 'porcentagens' => $porcentagens];
            }

            if ($question->type == 2){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                foreach($question->options as $option){
                    $filtered = Answer::withCount(['options' => function ($query) use($option) {
                        $query->where('id', $option->id);}])->where('question_id', $question->id)->get();
                    $respostas [$option->statement] = $filtered->sum('options_count');
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $porcentagens = [];
                foreach ($respostas as $k => $v){
                    if ($k != 'Total' && $respostas ['Total'] > 0)
                        $porcentagens [$k] = ($v / $respostas ['Total']) * 100;
                }

                $processamento [$question->id] = ['respostas' => $respostas, 'porcentagens' => $porcentagens];
            }

            if ($question->type == 3){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                if ($question->options->count()){
                    foreach($question->options as $option){
                        $filtered = $answers->where('question_id', $question->id);
                        foreach ($filtered as $resposta)
                            foreach ($resposta->options as $opcao)
                            if ($opcao->id == $option->id && $opcao->pivot->value)
                                $respostas [$option->statement] [] = $opcao->pivot->value;
                    }
                } else {
                    $respostas = $answer->pluck('value');
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $processamento [$question->id] = $respostas;
            }

            if ($question->type == 4){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                foreach($question->options as $option){
                    foreach ($answer as $resposta) {
                        foreach ($resposta->options as $opcao)
                            if ($opcao->id == $option->id){
                                $respostas [$option->statement]['resposta'][$resposta->id] = $opcao->pivot->value;
                            }
                    }
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $excluir = [];
                foreach ($respostas as $k => $v){
                    if (isset($v ['resposta']))
                        foreach ($v ['resposta'] as $chave => $valor)
                            if (is_null($valor)) $excluir [] = $chave;
                }
                foreach ($respostas as $k => $v){
                    if (isset($v ['resposta']))
                        foreach ($v ['resposta'] as $chave => $valor)
                            if (in_array($chave, $excluir)) unset($respostas[$k]['resposta'][$chave]);
                }
                foreach ($respostas as $k => $v){
                    if (isset($v ['resposta'])){
                        $respostas[$k]['contagem'] = count($v['resposta']);
                        if (count($v['resposta']) > 0)
                            $respostas[$k]['media'] = array_sum($v['resposta']) / count($v['resposta']);
                    }
                }
                $respostas ['Excluidas'] = count(array_unique($excluir));

                $processamento [$question->id] = $respostas;
            }

            if ($question->type == 5){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                foreach ($answer as $resposta) {
                    foreach ($resposta->options as $opcao){
                        if (is_numeric($opcao->pivot->value) && $opcao->pivot->value != 1)
                        $respostas [$opcao->statement]['resposta'][] = $opcao->pivot->value;
                    }
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                foreach ($respostas as $k => $v){
                    if (isset($v ['resposta'])){
                        $respostas[$k]['contagem'] = count($v['resposta']);
                        if (count($v['resposta']) > 0)
                            $respostas[$k]['media'] = array_sum($v['resposta']) / count($v['resposta']);
                    }
                }

                return $processamento [$question->id] = $respostas;
            }
        }

        return $processamento;

        return view('report.report', compact('survey', 'questions', 'sample', 'answers'));
    }

}
