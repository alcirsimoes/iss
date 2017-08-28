<?php

namespace App\Http\Controllers;

use App\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
<<<<<<< HEAD
        $samples = Sample::all();

        return view('sample.index')->with(compact('samples'));
=======
        return Sample::all();
>>>>>>> b6bc7def9bc2a5ebed49a975896c81d457772d24
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sample.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $sample = new Sample;
        $sample = $sample->fill($request->input());
        $sample->saveOrFail();

        return $sample;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function show(Sample $sample)
    {
<<<<<<< HEAD
        return view('sample.show')->with(compact('sample'));
=======
        return $sample;
>>>>>>> b6bc7def9bc2a5ebed49a975896c81d457772d24
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
