<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('reports.generalLedger')->with('types',AccountType::all());
    }
}
