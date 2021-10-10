<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;
use App\Models\Entry;
use App\Models\MaterialSpending;
use App\Models\Transaction;

class MaterialSpendingObserver
{
    /**
     * Handle the MaterialSpending "created" event.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return void
     */
    public function created(MaterialSpending $materialSpending)
    {
        $transaction_name = $materialSpending->material->category->name;
        $spent_on = $materialSpending->accountSpentOn->name;
        $transaction = Transaction::firstOrCreate([
            'transaction_name' => "انفاق $transaction_name على $spent_on",
            'transaction_date' => $materialSpending->date,
            'currency_id' => Currency::IS_SYP,
        ]);
        $materialsAccount = Account::firstOrCreate([
            'name' => 'مواد',
            'parent_id' => null,
            'account_type' => AccountType::IS_ASSET,
        ]);
        $crEntry = $this->createCreditEntry(
            $materialsAccount->id,
            Currency::IS_SYP,
            $materialSpending->qty_spent * $materialSpending->material->price,
            $transaction,
            $materialSpending->material->purchaseItem->purchase->currency_value
        );
        $drEntry = $this->createDebitEntry(
            $materialSpending->account_spent_on_id,
            Currency::IS_SYP,
            $materialSpending->qty_spent * $materialSpending->material->price,
            $transaction,
            $materialSpending->material->purchaseItem->purchase->currency_value
        );
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

    /**
     * Handle the MaterialSpending "updated" event.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return void
     */
    public function updated(MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Handle the MaterialSpending "deleted" event.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return void
     */
    public function deleted(MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Handle the MaterialSpending "restored" event.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return void
     */
    public function restored(MaterialSpending $materialSpending)
    {
        //
    }

    /**
     * Handle the MaterialSpending "force deleted" event.
     *
     * @param  \App\Models\MaterialSpending  $materialSpending
     * @return void
     */
    public function forceDeleted(MaterialSpending $materialSpending)
    {
        //
    }
}
