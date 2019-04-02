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

    public function isAdmin()
    {
        return $this->is_admin === 'admin';
    }

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

     public function profile() // profession + id  = profession_id
    {
        return $this->hasOne(UserProfile::class)->withDefault([
            'title' => '(Sin Profession)'
        ]); 
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill');
    }
    
    public static function createUser($data)
    {
        DB::transaction(function() use ($data)  {
            $user =User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => '',
            ]);

            $user->profile()->create([
                'profession_id' => $data['profession_id'],
                'bio' => $data['bio'],
                'twitter' => $data['twitter'],
            ]);
        });
    }

}
