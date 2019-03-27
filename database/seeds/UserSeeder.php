<?php

use Illuminate\Database\Seeder;

//add
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use App\Skill;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        /*
        factory(User::class,30)->create()->each(function ($user) use ($professions){
            $user->profile()->create([
                'user_id' => $user->id,
                'profession_id' => rand(0,2) ? $professions->random()->id : null,
            ]);

        });
        */
        
        $professions = profession::all();
        $skills = skill::all();
        
        factory(User::class,30)->create()->each(function ($user) use ($professions){
            $user->profile()->create(
                factory(\App\UserProfile::class)->raw([
                    'profession_id' => rand(0,2) ? $professions->random()->id : null,
                ])
            );
        });

        //factory(User::class,100)->create();
    }
}
