<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// add 
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, Searchable;
    
    //protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'password', 'role'
    ];


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

    public function profession() // profession + id  = profession_id
    {
        return $this->belongsTo(Profession::class)->withDefault([
            'title' => '(Sin profesión)'
        ]);
    }
    
    public function isAdmin()
    {
        return $this->is_admin === 'admin';
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'team' => $this->team,
        ];
    }

    public function scopezzzSearch($query, $search)
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

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
