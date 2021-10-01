<?php

namespace App\Observers;

use App\Models\Vendor;
use App\Models\Account;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return void
     */
    public function created(Vendor $vendor)
    {
        $parentLiabilityAccount = Account::all()->where('name', 'الموردين')->first();
        $parentExpenseAccount = Account::all()->where('name', 'مصاريف الموردين')->first();
        if ($parentLiabilityAccount && $parentExpenseAccount) {
            $liabilityAccount = Account::create([
                'name' => $vendor->name,
                'account_type' => $parentLiabilityAccount->account_type,
                'parent_id' => $parentLiabilityAccount->id,
            ]);
            $expenseAccount = Account::create([
                'name' => $vendor->name,
                'account_type' => $parentExpenseAccount->account_type,
                'parent_id' => $parentExpenseAccount->id
            ]);
            $vendor->update(['account_id' => $liabilityAccount->id, 'loss_account_id' => $expenseAccount->id,]);
        }
    }

    /**
     * Handle the Vendor "updated" event.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return void
     */
    public function updated(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "deleted" event.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return void
     */
    public function deleted(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "restored" event.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return void
     */
    public function restored(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return void
     */
    public function forceDeleted(Vendor $vendor)
    {
        //
    }
}
