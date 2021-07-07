<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Invertory;
use Illuminate\Http\Request;

class InvertoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invertory.index', ['invertories' => Invertory::all()->where('parent_id', null)->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invertory.create', ['invertories' => Invertory::all()]);
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
            'name' => 'required',
        ]);

        $invertory = Invertory::create($request->only('name', 'parent_id'));
        $fixedAccount = Account::all()->where('name', 'أصول ثابتة')->first();
        $invertoryAccount = Account::create([
            'name' => $request->name,
            'parent_id' => $invertory->parent_id ?
                $invertory->parent->account_id : $fixedAccount->id,
            'account_type' => 1 
        ]);
        $invertory->account_id = $invertoryAccount->id;
        $invertory->save();
        return redirect()->route('invertories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invertory  $invertory
     * @return \Illuminate\Http\Response
     */
    public function show(Invertory $invertory)
    {
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('invertory.show', ['invertory' => $invertory,'currency'=>$currency]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invertory  $invertory
     * @return \Illuminate\Http\Response
     */
    public function edit(Invertory $invertory)
    {
        return view('invertory.edit', ['invertory', $invertory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invertory  $invertory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invertory $invertory)
    {
        $invertory->name = $request->name;
        $invertory->parent_id = $request->parent_id;
        $invertory->save();
        return redirect()->route('invertories.show', ['invertory' => $invertory]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invertory  $invertory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invertory $invertory)
    {
        $invertory->delete();
        return redirect()->route('invertories.index');
    }
}
