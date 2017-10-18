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

class DirectController extends Controller
{
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

    public function email(Request $request, Survey $survey, Subject $subject)
    {
        # code...
    }
}
