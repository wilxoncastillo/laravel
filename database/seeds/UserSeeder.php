<?php

use Illuminate\Database\Seeder;

//add
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = profession::all();
        
        factory(User::class,30)->create()->each(function ($user){
            $user->profile()->create(
                factory(\App\UserProfile::class)->raw()
            );
        });

        factory(User::class,100)->create();
    }
}
