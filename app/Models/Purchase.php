<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Purchase extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = ['date', 'vendor_id', 'transaction_id', 'currency_value', 'type'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
