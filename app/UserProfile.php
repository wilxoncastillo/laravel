<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//add
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'profession_id','bio', 'twitter',
    ];

    use SoftDeletes;
    
    public function profession() // profession + id  = profession_id
    {
        return $this->belongsTo(Profession::class)->withDefault();
    }
}
