<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Attachment;
use App\Models\Currency;
use App\Models\CurrencyExchange;
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

        if ($request->image) {
            $imageName = time() . $asset->name . '.' . $request->image->extension();
            $request->image->storeAs('attachments', $imageName, 'public');
            $attachment = Attachment::create([
                'url' => $imageName,
            ]);
            $asset->attachment_id = $attachment->id;
            $asset->save();
        }

        $fixedAccount = Account::all()->where('name', 'أصول ثابتة')->first();

        $assetAccount = Account::create([
            'name' => $asset->name,
            'parent_id' => $asset->invertory->account_id,
            'account_type' => $fixedAccount->account_type,
        ]);

        $asset->account_id = $assetAccount->id;
        $asset->save();
        $usdCurrency = Currency::where('code', 'USD')->first();
        $sypCurrency = Currency::where('code', 'SYP')->first();
        if (session('currency_id') == $usdCurrency->id) {
            $currencyVALUE = $this->processUsdFifo($asset->value);
            if ($currencyVALUE == 'error') {
                alert()->error('You don\'t have enought money exchanged to USD currency');
                return redirect()->back();
            }
            $unMirroredTransaction = $this->createTransaction('شراء ' . $request->name, $request->purchase_date, $sypCurrency->id, $request->description);
            $mirroredTransaction = $this->createTransaction('(قيد معكوس) شراء ' . $request->name, $request->purchase_date, $sypCurrency->id, 'هذا القيد معكوس...\n' . $request->description);
            $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
            $crRecord_mirrored = $this->createCreditEntry($exchange_expense_account->id, $sypCurrency->id, $asset->value * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $drRecord_mirrored = $this->createDebitEntry($asset->account_id, $sypCurrency->id, $asset->value * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $crRecord = $this->createCreditEntry($asset->purchase_account, $usdCurrency->id, $asset->value, $unMirroredTransaction, $currencyVALUE);
            $drRecord = $this->createDebitEntry($asset->account_id, $usdCurrency->id, $asset->value, $unMirroredTransaction, $currencyVALUE);
        } else {
            $newTransaction = $this->createTransaction('شراء ' . $request->name, $request->purchase_date, $sypCurrency->id, $request->description);
            $crRecord = $this->createCreditEntry($asset->purchase_account, $sypCurrency->id, $asset->value, $newTransaction, $request->currency_value);
            $drRecord = $this->createDebitEntry($asset->account_id, $sypCurrency->id, $asset->value, $newTransaction, $request->currency_value);
            alert()->success('Successfully completed transaction');
        }

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

    function processUsdFifo($RecieptTotal)
    {
        $usdCurrency = Currency::where('code', 'USD')->first();
        if (session('currency_id') != $usdCurrency->id) return;
        $allExchanges = CurrencyExchange::whereColumn('amount', '>', 'amount_spent')->where('currency_to', $usdCurrency->id)->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();
        $batches = array();
        $amount = 0;
        $totalAvailableAmount = 0;
        $totalRemainingAmount = $RecieptTotal; // 2000
        $totalAmountSyp = 0; // 0
        $count = 0;
        foreach ($allExchanges as $batch) {
            $totalAvailableAmount += $batch->amount - $batch->amount_spent;
            array_push($batches, $batch);
            $count++;
            if ($totalAvailableAmount >= $RecieptTotal) {
                foreach ($batches as $b) {
                    if ($b->amount - $b->amount_spent >= $totalRemainingAmount) {

                        $amount += $totalRemainingAmount; // 1000$ + 1000$ = 2000$
                        $totalAmountSyp += $totalRemainingAmount * $b->currency_value; //500,000s.p += 1000$ * 600 = 1,100,000
                        $b->amount_spent += $totalRemainingAmount;
                        $b->save();
                        break;
                    } else {
                        $totalRemainingAmount -= ($b->amount - $b->amount_spent); //2000 - 1000 = 1000
                        $amount += $b->amount - $b->amount_spent; // 1000
                        $totalAmountSyp += $amount * $b->currency_value; // 1000 * 500 = 500,000
                        $b->amount_spent += $b->amount - $b->amount_spent;
                        $b->save();
                    }
                }
                break;
            }
        }
        if ($totalAvailableAmount < $RecieptTotal) {
            return 'error';
        }
        toast()->success('Successfully spent ' . $totalAmountSyp . ' at the currency_value of ' . $totalAmountSyp / $amount);
        return $totalAmountSyp / $amount; // array('TotalAmountSyp' => $totalAmountSyp, 'TotalAmountUsd' => $amount);
    }

    public function createTransaction($transaction_name, $transaction_date, $currency_id, $description)
    {
        $transaction = Transaction::create([
            'transaction_name' => $transaction_name,
            'transaction_date' => $transaction_date,
            'currnecy_id' => $currency_id,
            'description' => $description,
        ]);
        return $transaction;
    }

    public function createCreditEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value)
    {
        $crEntry = Entry::create([
            'cr' => $amount,
            'account_id' => $account_id,
            'currency_id' => $currency_id,
            'currency_value' => $currency_value,
            'transaction_id' => $transaction->id,
        ]);
        return $crEntry;
    }
    public function createDebitEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value)
    {
        $drEntry = Entry::create([
            'dr' => $amount,
            'account_id' => $account_id,
            'currency_id' => $currency_id,
            'currency_value' => $currency_value,
            'transaction_id' => $transaction->id,
        ]);
        return $drEntry;
    }
}
