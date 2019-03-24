<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Kill extends Model
{
    protected $fillable = [
        'user_id', 'skill_id',
    ];
}
