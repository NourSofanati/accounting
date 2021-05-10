<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Entry;
use App\Models\FixedAsset;
use App\Models\Invertory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fixedassets.index', ['assets' => FixedAsset::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invertory $invertory)
    {

        return view('fixedassets.create');
    }


    public function createFromInvertory(Invertory $invertory)
    {
        return view('invertory.createFromInvertory', [
            'invertories' => array($invertory),
            'equityAccounts' => Account::all()->where('account_type', 3),
        ]);
    }
    public function purchaseFromInvertory(Invertory $invertory)
    {

        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('invertory.createFromInvertory', [
            'invertories' => array($invertory),
            'equityAccounts' => $accounts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asset = FixedAsset::create([
            'name' => $request->name,
            'value' => $request->value,
            'supervisor' => $request->supervisor,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
            'purchase_account' => $request->purchase_account,
            'purchase_date' => $request->purchase_date,
            'invertory_id' => $request->invertory_id,
        ]);

        $fixedAccount = Account::all()->where('name', 'أصول ثابتة')->first();

        $assetAccount = Account::create([
            'name' => $asset->name,
            'parent_id' => $asset->invertory->account_id,
            'account_type' => $fixedAccount->account_type,
        ]);

        $asset->account_id = $assetAccount->id;
        $asset->save();

        $transaction = Transaction::create([
            'transaction_name' => 'Asset ' . sprintf("%07d", $asset->id),
            'transaction_date' => $asset->purchase_date,
            'currency_value' => $asset->currency_value,
            'currency_id' => $request->session()->get('currency_id'),
        ]);
        Entry::create([
            'currency_value' => $asset->currency_value,
            'currency_id' => $asset->currency_id,
            'cr' => $asset->value,
            'account_id' => $asset->purchase_account,
            'transaction_id' => $transaction->id,
        ]);
        Entry::create([
            'currency_value' => $asset->currency_value,
            'currency_id' => $asset->currency_id,
            'dr' => $asset->value,
            'account_id' => $asset->account_id,
            'transaction_id' => $transaction->id,
        ]);
        return redirect()->route('invertories.show', $request->invertory_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function show(FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedAsset $fixedAsset)
    {
        //
    }
}
