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
    //use Notifiable, SoftDeletes, Searchable;
    use Notifiable, SoftDeletes;

    //protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'password', 'role', 'active'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'active' => 'bool',
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

    public function scopeSearch($query, $search)
    {
        if (empty ($search)) {
            return;
        }

        $query
            ->where('first_name', 'like', "%{$search}%")
            ->where('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('team', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
    }

    public function scopeByState($query, $state)
    {
        if ($state == 'active') {
            return $query->where('active', true);
        }

        if ($state == 'inactive') {
            return $query->where('active', false);
        }
    }

    public function scopeByRole($query, $role)
    {
        if (in_array($role, ['admin','user']))
        {
            $query->where('role', $role);
        }
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function setStateAttribute($value)
    {
        $this->attributes['active'] = $value == 'active';
    }

    public function getStateAttribute()
    {
        if ($this->active !== null) {
            return $this->active ? 'active' : 'inactive';
        }
    }
}
