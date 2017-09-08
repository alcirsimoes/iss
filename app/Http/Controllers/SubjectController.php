<?php

namespace App\Http\Controllers;

use App\Sample;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
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
        return Subject::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sample = new Sample;
        if (request('id')) $sample = Sample::find(request('id'));

        return view('subject.create')->with(compact('sample'));
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
            'name' => 'required|max:255',
        ]);

        $subject = Subject::create($request->all());

        if ($sample_id = request('sample_id')) {
            $sample = Sample::findOrFail($sample_id);
            $sample->subjects()->save($subject);

            if (request('redirect'))
                return redirect()->route('form.create', [$sample->surveys->first()->id, $subject->id]);
        }

        return redirect()->route('subject.show', $subject->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return $subject;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $valid = $request->validate([
            'name' => 'required|max:255',
        ]);

        $subject = $subject->fill($request->input());
        $subject->saveOrFail();

        return $subject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        return $subject->delete();
    }
}
