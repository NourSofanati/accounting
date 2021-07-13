<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Attachment;
use App\Models\AttachmentGroup;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Entry;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\InvoiceTax;
use App\Models\RetainedPayment;
use App\Models\Tax;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;
use PDF;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoices = Invoice::orderBy('created_at', 'desc')->where('currency_id', session('currency_id'))->get();
        $colors = array(
            "مسودة" => "gray",
            "مرسلة" => "yellow",
            "مدفوعة" => "green"
        );
        $revenueSplit = array(
            "draft" => 0,
            "recievables" => 0,
            "paid" => 0,
            "paidTaxes" => 0,
            "retains" => 0,
        );
        foreach ($invoices as $invoice) {
            if ($invoice->status == "مسودة") {
                $revenueSplit["draft"] += $invoice->totalDue();
            } else {
                $revenueSplit["recievables"] += $invoice->totalDue();
                $revenueSplit["paid"] += $invoice->totalPaid() - $invoice->totalTaxes();
                $revenueSplit["paidTaxes"] += $invoice->totalTaxes();
                $revenueSplit["retains"] += $invoice->totalRetains();
            }
        }
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('invoices.index')->with('invoices', $invoices)->with('colors', $colors)->with('revenue', $revenueSplit)->with('currency', $currency);
    }


    public function getUSDprice()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sp-today.com/app_api/cur_damascus.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfduid=d7a4fb1bb5b25294faef13949ef102ae21615128843'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $USDprice = (array_filter(json_decode($response), function ($arrItem) {
            return $arrItem->name == 'USD';
        }));
        return $USDprice;
    }

    public function generatePDF(Invoice $invoice)
    {


        //$pdf = App::make('dompdf.wrapper');

        //        $pdf = PDF::loadView('invoices.pdf', ['invoice' => $invoice]);

        return view('invoices.pdf', ['invoice' => $invoice]);
    }
    public function claimRetains()
    {
        $retains = RetainedPayment::all()->where('paid', '!=', true)->all();
        $USDprice = $this->getUSDprice();
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);

        return view('invoices.retains', ['retains' => $retains, 'parentAccounts' => $accounts, 'USDprice' => $USDprice[0]->bid]);
    }
    public function claimRetainsStore(Request $request)
    {
        $retains = RetainedPayment::all()->where('paid', '!=', true)->all();

        foreach ($retains as $key) {
            $invoice = $key->invoice;
            $transaction = Transaction::find($invoice->transaction_id);
            Entry::create([
                'currency_value' => $request->currency_value,
                'currency_id' => $invoice->currency_id,
                'cr' => $key->amount,
                'account_id' => $invoice->customer->profit_account_id,
                'transaction_id' => $transaction->id,
            ]);
            Entry::create([
                'currency_value' => $request->currency_value,
                'currency_id' => $invoice->currency_id,
                'dr' => $key->amount,
                'account_id' => $request->designatedAccountId,
                'transaction_id' => $transaction->id,
            ]);
            InvoicePayment::create([
                'date' => $request->date,
                'amount' => $key->amount,
                'invoice_id' => $invoice->id,
                'currency_id' => $invoice->currency_id,
                'currency_value' => $request->currency_value
            ]);
            $key->paid = true;
            $key->save();
        }
        return redirect()->route('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $draftInvoice = Invoice::create();
        $cashAccounts = Account::all()->where('account_type', 1)->all();
        $customers = Customer::all();

        $USDprice = $this->getUSDprice();
        return view('invoices.create', ['currency' => Currency::all()])
            ->with('cashAccounts', $cashAccounts)
            ->with('customers', $customers)
            ->with('draftInvoice', $draftInvoice)
            ->with('USDprice', $USDprice[0]->bid);
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
            'filenames' => 'required',
            'filenames.*' => 'mimes:jpeg,jpg,png,gif,doc,pdf,docx,zip'
        ]);
        $invoice = Invoice::find($request->invoiceNumber);
        $invoice->issueDate = $request->issueDate;
        $invoice->dueDate = $request->dueDate;
        $invoice->customer_id = $request->customer_id;
        $invoiceTransaction = Transaction::create([
            'transaction_name' => 'Invoice ' . sprintf("%07d", $invoice->id),
            'transaction_date' => $invoice->issueDate,
            'invoice_id' => $invoice->id,
            'currency_value' => $request->currency_value,
            'currency_id' => $request->session()->get('currency_id'),
        ]);
        $invoice->transaction_id = $invoiceTransaction->id;
        $invoice->currency_id = $request->session()->get('currency_id');
        $invoice->currency_value = $request->currency_value;
        $attachment_group = AttachmentGroup::create();
        $invoice->attachment_group_id = $attachment_group->id;
        $invoice->save();
        if ($request->hasfile('filenames')) {
            foreach ($request->file('filenames') as $file) {
                // $name = time() . '.' . $file->extension();
                // $file->move(public_path() . '/files/', $name);
                // $data[] = $name;
                $imageName = "invoice" . sprintf("%08d", $invoice->id) . ' ' . $file->name . ' .' . $file->extension();
                $file->storeAs('images', $imageName, 'public');
                $attachment = Attachment::create([
                    'url' => $imageName,
                    'group_id' => $invoice->attachment_group_id
                ]);
            }
        }
        foreach ($request->entries as $index => $entry) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'rate' => $entry['rate'],
                'qty' => $entry['qty'],
                'description' => $entry['description'],
            ]);
        }

        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $dueAmount = 0;
        foreach ($invoice->items as $item) {
            $dueAmount += ($item->qty * $item->rate);
        }
        foreach ($invoice->taxes as $item) {
            $dueAmount += $item->amount;
        }
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('invoices.show')->with('invoice', $invoice)->with('dueAmount', $dueAmount)->with('currency', $currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
    }

    public function sent(Invoice $invoice)
    {
        $transaction = Transaction::find($invoice->transaction_id);
        Entry::create([
            'currency_value' => $invoice->currency_value,
            'currency_id' => $invoice->currency_id,
            'cr' => $invoice->total(),
            'account_id' => $invoice->customer->profit_account_id,
            'transaction_id' => $transaction->id,
        ]);
        Entry::create([
            'currency_value' => $invoice->currency_value,
            'currency_id' => $invoice->currency_id,
            'dr' => $invoice->total(),
            'account_id' => $invoice->customer->account_id,
            'transaction_id' => $transaction->id,
        ]);
        $invoice->status = 'مرسلة';
        $invoice->save();
        return redirect()->route('invoices.show', $invoice);
    }

    public function addPaymentPage(Invoice $invoice)
    {
        $USDprice = $this->getUSDprice();
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('invoices.payment', ['invoice' => $invoice, 'parentAccounts' => $accounts, 'USDprice' => $USDprice[0]->bid]);
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $transaction = Transaction::find($invoice->transaction_id);

        $remainerAmount = $request->paidAmount;

        if ($request->taxItems) {
            foreach ($request->taxItems as $key => $value) {
                $remainerAmount -= $value['tax_amount'];
                InvoiceTax::create([
                    'invoice_id' => $invoice->id,
                    'tax_id' => $value['tax_id'],
                    'amount' => $value['tax_amount'],
                ]);
                $Tax = Tax::find($value['tax_id']);
                Entry::create([
                    'currency_id' => $request->session()->get('currency_id'),
                    'currency_value' => $request->currency_value,
                    'cr' => $value['tax_amount'],
                    'account_id' => $invoice->customer->account_id,
                    'transaction_id' => $transaction->id,
                ]);
                Entry::create([
                    'currency_id' => $request->session()->get('currency_id'),
                    'currency_value' => $request->currency_value,
                    'dr' => $value['tax_amount'],
                    'account_id' => $Tax->account->id,
                    'transaction_id' => $transaction->id,
                ]);
            }
        }

        if ($request->retainAmount) {
            RetainedPayment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->retainAmount,
            ]);
        }
        Entry::create([
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
            'cr' => $remainerAmount - $request->retainAmount,
            'account_id' => $invoice->customer->account_id,
            'transaction_id' => $transaction->id,
        ]);
        Entry::create([
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
            'dr' => $remainerAmount - $request->retainAmount,
            'account_id' => $request->designatedAccountId,
            'transaction_id' => $transaction->id,
        ]);
        InvoicePayment::create([
            'date' => $request->date,
            'amount' => $request->paidAmount - $request->retainAmount,
            'invoice_id' => $invoice->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value
        ]);
        if ($invoice->totalDue() <= 0) {
            $invoice->status = "مدفوعة";
            $invoice->save();
        }
        return redirect()->route('invoices.show', $invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
