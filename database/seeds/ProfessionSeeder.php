<?php

use Illuminate\Database\Seeder;

//add
use Illuminate\Support\Facades\DB;
use App\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        db::insert('insert into professions (title) values ("Arquitecto de Sofware")');
        db::insert('insert into professions (title) values (?)',['Analista de Sistemas']);
        //db::insert('insert into professions (title) values (:title)',['title' => 'Analista de Sistemas']);

        DB::table('professions')->insert([
            'title' => 'Desarrollador back-end',
        ]);
        
        DB::table('professions')->insert([
            'title' => 'Desarrollador front-end',
        ]);
        
        DB::table('professions')->insert([
            'title' => 'Desarrollador Web',
        ]);
        
        DB::table('professions')->insert([
            'title' => 'Diseñador WEB',
        ]);
        
        DB::table('professions')->insert([
            'title' => 'DBA',
        ]);

        //----------------------
        // use App\Profession 
        \App\Profession::create([
            'title' => 'Contador',
        ]);
        

        Profession::create([
            'title' => 'Arquiecto',
        ]);
    }
}
