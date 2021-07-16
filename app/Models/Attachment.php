<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'group_id','name'];
    public function attachment_group()
    {
        return $this->belongsTo(AttachmentGroup::class,'group_id');
    }
}
