<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendors.index')->with('vendors', $vendors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.create');
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
            'phone' => 'numeric|nullable',
            'address' => 'nullable',
        ]);
        $parentLiabilityAccount = Account::all()->where('name', 'الموردين')->first();
        $parentExpenseAccount = Account::all()->where('name', 'مصاريف الموردين')->first();
        //dd($parentExpenseAccount,$parentLiabilityAccount);
        if ($parentLiabilityAccount && $parentExpenseAccount) {
            $liabilityAccount = Account::create([
                'name' => $request->name,
                'account_type' => $parentLiabilityAccount->account_type,
                'parent_id' => $parentLiabilityAccount->id,
            ]);
            $expenseAccount = Account::create([
                'name' => $request->name,
                'account_type' => $parentExpenseAccount->account_type,
                'parent_id' => $parentExpenseAccount->id
            ]);
            Vendor::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'account_id' => $liabilityAccount->id,
                'loss_account_id' => $expenseAccount->id,
            ]);
            return redirect()->route('vendors.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        
        return view('vendors.show', ['vendor' => $vendor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
