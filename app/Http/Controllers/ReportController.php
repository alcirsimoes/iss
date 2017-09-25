<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Survey;
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
        $answers = Answer::where(['sample_id'=>$sample->id, 'subject_id'=>$subject->id])->get();

        return view('report.view', compact('survey', 'sample', 'subject', 'answers'));
    }

}
