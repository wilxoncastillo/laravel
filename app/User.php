<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//add
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $perPage = 10;
    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function findByEmail($email)
    {
        return static::where(compact('email'))->first();
    }
    
    public function team() // profession + id  = profession_id
    {
        return $this->belongsTo(Team::class)->withDefault([
            'name' => '(Sin equipo)'
        ]);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill');
    }

    public function profile() // profession + id  = profession_id
    {
        return $this->hasOne(UserProfile::class)->withDefault([
            'title' => '(Sin Profession)'
        ]); 
    }
    
    public function isAdmin()
    {
        return $this->is_admin === 'admin';
    }

    public function scopeSearch($query, $search)
    {
        if (empty ($search)) {
            return;
        }

        /*
            ->when(request('team'), function ($query, $search) {
                if($team === 'with_team') {
                    $query->has('team');
                } elseif($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('team', function ($query) use ($search){
                           $query->where('name', 'like', "%$search%"); 
                        });
                });
            })
        */ 

        $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('team', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });   
    }
}
