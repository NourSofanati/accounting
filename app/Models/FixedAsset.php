<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'value',
        'supervisor',
        'vendor_id',
        'account_id',
        'expense_account_id',
        'invertory_id',
        'purchase_account',
        'purchase_date',
        'purchase_item_id',
        'currency_id',
        'currency_value',
        'attachment_id',
        "depreciation_rate"
    ];
    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class, 'purchase_item_id');
    }

    public function invertory()
    {
        return $this->belongsTo(Invertory::class, 'invertory_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }


    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function expensesGroup()
    {
        return $this->hasOne(FixedAssetExpenseGroup::class, 'asset_id');
    }
}
