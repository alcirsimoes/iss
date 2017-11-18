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
        ini_set('memory_limit','512M');

        $questions = $survey->questions;
        $answers = Answer::with('options')->where('sample_id', $sample->id)->get();
        $answers = $answers->filter(function($item){
            return !is_null($item->subject);
        });

        $tipo = 5;

        $processamento = [];
        foreach($questions as $question){
        if ($question->type == 1 /*&& $tipo == 1*/){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                // foreach($question->options as $option)
                //     $respostas [$option->statement] = 0;

                foreach ($answer as $resposta){
                    $opcao = $resposta->options->first();
                    if ($opcao){
                        if (isset($respostas [$opcao->statement]))
                            $respostas [$opcao->statement] += 1;
                        else $respostas [$opcao->statement] = 1;
                    }
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não Sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $porcentagens = [];
                foreach ($respostas as $k => $v){
                    if ($k != 'Total' && $respostas ['Total'] > 0)
                        $porcentagens [$k] = ($v / $respostas ['Total']) * 100;
                }

                $processamento [$question->id] = ['respostas' => $respostas, 'porcentagens' => $porcentagens];
            }

        if ($question->type == 2 /*&& $tipo == 2*/){
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                // foreach($question->options as $option)
                //     $respostas [$option->statement] = 0;

                foreach ($answer as $resposta){
                    foreach ($resposta->options as $opcao)
                        if ($opcao){
                            if (isset($respostas [$opcao->statement]))
                                $respostas [$opcao->statement] += 1;
                            else $respostas [$opcao->statement] = 1;
                        }
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não Sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $porcentagens = [];
                foreach ($respostas as $k => $v){
                    if ($k != 'Total' && $respostas ['Total'] > 0)
                        $porcentagens [$k] = ($v / $respostas ['Total']) * 100;
                }

                $processamento [$question->id] = ['respostas' => $respostas, 'porcentagens' => $porcentagens];
            }

        if ($question->type == 3 /*&& $tipo == 3*/){
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
                $respostas ['Não Sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                $processamento [$question->id] = $respostas;
            }

        if ($question->type == 4 /*&& $tipo == 4*/){
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
                $respostas ['Não Sabe'] = $answer->whereNotIn('dontknow', [0])->count();
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

        if ($question->type == 5 /*&& $tipo == 5*/){
                $options = $question->options;
                $answer = $answers->where('question_id', $question->id);

                $respostas = [];
                foreach ($answer as $resposta) {
                    foreach ($resposta->options as $opcao){
                        if (is_numeric($opcao->pivot->value) && $opcao->pivot->value != 1){
                            if ($opcao->pivot->sub_option_id){
                                $subopcao = $options->where('id', $opcao->pivot->sub_option_id)->first();
                                $respostas [$opcao->statement][$subopcao->statement]['resposta'][] = $opcao->pivot->value;
                            } else
                                $respostas [$opcao->statement]['resposta'][] = $opcao->pivot->value;
                        }
                    }
                }
                $respostas ['Recusou'] = $answer->whereNotIn('refused', [0])->count();
                $respostas ['Não Sabe'] = $answer->whereNotIn('dontknow', [0])->count();
                $respostas ['Total'] = $answer->count();

                foreach ($respostas as $k => $v){
                    if (isset($v ['resposta'])){
                        $respostas[$k]['contagem'] = count($v['resposta']);
                        if (count($v['resposta']) > 0)
                            $respostas[$k]['media'] = array_sum($v['resposta']) / count($v['resposta']);
                    }
                    if ($options) foreach($options as $suboption){
                        if (isset($v[$suboption->statement]['resposta'])){
                            $respostas[$k][$suboption->statement]['contagem'] = count($v[$suboption->statement]['resposta']);

                            if (count($v[$suboption->statement]['resposta']) > 0)
                                $respostas[$k][$suboption->statement]['media'] = array_sum($v[$suboption->statement]['resposta']) / count($v[$suboption->statement]['resposta']);
                        }
                    }
                }

                $processamento [$question->id] = $respostas;
            }
        }

        // return $processamento;
        // return $questions;

        return view('report.report', compact('survey', 'questions', 'sample', 'processamento'));
    }

}
