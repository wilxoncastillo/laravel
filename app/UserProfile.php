<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'profession_id','bio', 'twitter',
    ];

    
    public function profession() // profession + id  = profession_id
    {
        return $this->belongsTo(Profession::class)->withDefault();
    }
}
