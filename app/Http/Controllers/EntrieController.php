<?php

namespace App\Http\Controllers;

use App\Sample;
use App\Entrie;
use Illuminate\Http\Request;

class EntrieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Entrie::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sample = Sample::findOrFail(request('id'));

        return view('entrie.create')->with(compact('sample'));
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
            'name' => 'required|max:255',
        ]);

        $entrie = new Entrie;
        $entrie = $entrie->fill($request->input());
        $entrie->saveOrFail();

        return $entrie;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entrie  $entrie
     * @return \Illuminate\Http\Response
     */
    public function show(Entrie $entrie)
    {
        return $entrie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entrie  $entrie
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrie $entrie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entrie  $entrie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrie $entrie)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $entrie = $entrie->fill($request->input());
        $entrie->saveOrFail();

        return $entrie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entrie  $entrie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrie $entrie)
    {
        return $entrie->delete();
    }
}
