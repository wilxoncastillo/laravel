<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professions extends Model
{
    // Se usa para las tablas que no cumple la convension
    //protected $tabla = 'mi_tabla';
    
    // para no guardar creatre_at update_at
    //public $timestamps = false;

    protected $fillable = ['title'];

    // una profession tiene muchos usuarios
    public function users()
    {
        //Illuminate\Database\Eloquent\Collection
        return $this->hasMany(User::class);
    }
}
