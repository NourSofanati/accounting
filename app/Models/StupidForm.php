<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StupidForm extends Model
{
    use HasFactory;
    protected $fillable = ['formHTML'];
}
