<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    // Se usa para las tablas que no cumple la convension
    //protected $tabla = 'mi_tabla';
    
    // para no guardar creatre_at update_at
    //public $timestamps = false;

    protected $fillable = ['title'];

    public function profiles()
    {
        return $this->hasMany(UserProfile::class);
    }
}
