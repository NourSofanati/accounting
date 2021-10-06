<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invertory;
use App\Models\MaterialCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
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
        //
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
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialCategory $materialCategory)
    {
        return view('materials.categories.show', compact('materialCategory'));
    }

    /**
     * Show the form for creating a new resource with a material category.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function showCreate(MaterialCategory $materialCategory)
    {

        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        $vendors = Vendor::all();
        return view('materials.purchase', [
            'invertories' =>  Invertory::where('parent_id', null)->get(),
            'equityAccounts' => $accounts,
            'vendors' => $vendors,
            'materialCategory' => $materialCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialCategory $materialCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialCategory $materialCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialCategory $materialCategory)
    {
        //
    }
}
