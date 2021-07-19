<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentGroup extends Model
{
    use HasFactory;
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'group_id','id');
    }
}
