<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
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
    public function index()
    {
        $samples = Sample::all();

        return view('sample.index')->with(compact('samples'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $survey = New Survey;
        if($request->has('id')) $survey = Survey::find(request('id'));

        return view('sample.create', compact('survey'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|max:255'
        ]);

        $sample = Sample::create($request->all());

        if ($survey_id = request('survey_id')) {
            $survey = Survey::findOrFail($survey_id);
            $survey->samples()->save($sample);
        }

        return redirect()->route('sample.show', $sample->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function show(Sample $sample)
    {
        return view('sample.show')->with(compact('sample'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function edit(Sample $sample)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sample $sample)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $sample = $sample->fill($request->input());
        $sample->saveOrFail();

        return $sample;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sample $sample)
    {
        return $sample->delete();
    }
}
