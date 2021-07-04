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
        'account_id',
        'invertory_id',
        'purchase_account',
        'purchase_date',
        'currency_id',
        'currency_value',
        'attachment_id',
    ];

    public function invertory()
    {
        return $this->belongsTo(Invertory::class, 'invertory_id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
