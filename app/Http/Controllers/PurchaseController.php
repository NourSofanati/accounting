<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\FixedAsset;
use App\Models\Invertory;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseItemAttributes;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('purchases.index')
            ->with('purchases', Purchase::all())->with('currency', $currency);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        $vendors = Vendor::all();
        return view('purchases.create', [
            'invertories' =>  Invertory::where('parent_id', null)->get(),
            'equityAccounts' => $accounts,
            'vendors' => $vendors
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
        //dd($request->all());
        $purchase = Purchase::create($request->all());
        foreach ($request->item as $item) {
            $purchaseItem = PurchaseItem::create($item + ['purchase_id' => $purchase->id]);
            if (isset($item["attributes"]) && count($item["attributes"]) > 0) {
                foreach ($item["attributes"] as $attribute) {
                    PurchaseItemAttributes::create($attribute + ['purchase_item' => $purchaseItem->id]);
                }
            }
        }
        dd($purchase);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
