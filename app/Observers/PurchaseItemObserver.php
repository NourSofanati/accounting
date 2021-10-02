<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\Entry;
use App\Models\Account;
use App\Models\FixedAsset;
use App\Models\PurchaseItem;

class PurchaseItemObserver
{
    /**
     * Handle the PurchaseItem "created" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function created(PurchaseItem $purchaseItem)
    {
        $purchase = $purchaseItem->purchase;
        $transaction = $purchase->transaction;
        $vendor = $purchase->vendor;
        if ($purchase->type == 'asset') {
            for ($i = 0; $i < $purchaseItem->qty; $i++) {

                $asset = FixedAsset::create([
                    'name' => $purchaseItem->item_name,
                    'value' => $purchaseItem->price,
                    'currency_id' => 1,
                    'currency_value' => $purchase->currency_value,
                    'purchase_date' => $purchase->date,
                    'invertory_id' => $purchase->invertory_id,
                    'vendor_id' => $purchase->vendor_id,
                ]);
                $fixedAccount = Account::all()->where('name', 'أصول ثابتة')->first();
                $assetAccount = Account::create([
                    'name' => $asset->name,
                    'parent_id' => $asset->invertory->account_id,
                    'account_type' => $fixedAccount->account_type,
                ]);
                $expenseAccount = Account::all()->where('name', 'نفقات الأصول')->first();
                $assetExpenseAccount = Account::create([
                    'name' => $asset->name,
                    'parent_id' => $asset->invertory->expense_account_id,
                    'account_type' => $expenseAccount->account_type,
                ]);
                $asset->account_id = $assetAccount->id;
                $asset->expense_account_id = $assetExpenseAccount->id;
                $asset->save();
                $crRecord = $this->createCreditEntry($vendor->account_id, 1, $asset->value, $transaction,  $purchase->currency_value);
                $drRecord = $this->createDebitEntry($asset->account_id, 1, $asset->value, $transaction,  $purchase->currency_value);
            }
        } else {
        }
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
     * Handle the PurchaseItem "updated" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function updated(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Handle the PurchaseItem "deleted" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function deleted(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Handle the PurchaseItem "restored" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function restored(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Handle the PurchaseItem "force deleted" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function forceDeleted(PurchaseItem $purchaseItem)
    {
        //
    }
}
