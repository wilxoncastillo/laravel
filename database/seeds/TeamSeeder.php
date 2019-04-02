<?php

use Illuminate\Database\Seeder;

//add
//use App\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Team::class)->create(['name' => 'Styde']);
        factory(\App\Team::class)->create(['name' => 'Microwave SpA']);
        factory(\App\Team::class)->create(['name' => 'Tuburon Digtal SpA']);
        factory(\App\Team::class,97)->create();
        
    }
}
