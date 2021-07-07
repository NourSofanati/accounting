<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\Currency;
use Illuminate\Http\Request;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        $currency = Currency::all()->where('id', session('currency_id'))->first();
        return view('reports.generalLedger')->with('types', AccountType::all())->with('currency', $currency);
    }
    public function create()
    {
            
    }
}
