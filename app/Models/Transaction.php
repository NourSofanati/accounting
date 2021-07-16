<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_name', 'transaction_date', 'description', 'currency_id','mirror_id','attachment_group_id'
    ];
    public function entries()
    {
        return $this->hasMany(Entry::class, 'transaction_id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'transaction_id');
    }
    public function mirror()
    {
        return $this->hasOne(Transaction::class, 'mirror_id');
    }
    public function attachment_group()
    {
        return $this->belongsTo(AttachmentGroup::class, 'attachment_group_id');
    }
}
