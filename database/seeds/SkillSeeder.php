<?php

use Illuminate\Database\Seeder;

//add
use Illuminate\Support\Facades\DB;
use App\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(Skill::class,20)->create();
        factory(\App\Skill::class)->create(['name' => 'HTML']);
        factory(\App\Skill::class)->create(['name' => 'CSS']);
        factory(\App\Skill::class)->create(['name' => 'JQUERY']);
        factory(\App\Skill::class)->create(['name' => 'DBA']);
        factory(\App\Skill::class)->create(['name' => 'ANGULAR']);
        factory(\App\Skill::class)->create(['name' => 'LARAVEL']);
        factory(\App\Skill::class)->create(['name' => 'JS']);
    }
}
