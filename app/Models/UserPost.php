<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    //
    protected $fillable = [
        'title', 'description','tag','uid',
    ];
}
