<?php

namespace App\Http\Controllers;

use App\Models\StupidForm;
use Illuminate\Http\Request;

class StupidFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stupid.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StupidForm  $stupidForm
     * @return \Illuminate\Http\Response
     */
    public function show(StupidForm $stupidForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StupidForm  $stupidForm
     * @return \Illuminate\Http\Response
     */
    public function edit(StupidForm $stupidForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StupidForm  $stupidForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StupidForm $stupidForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StupidForm  $stupidForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(StupidForm $stupidForm)
    {
        //
    }
}
