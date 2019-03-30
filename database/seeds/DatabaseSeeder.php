<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable([
            'users',
            'user_profiles',
            'user_skill',
            'skills',
            'professions',
        ]);

        /*
        $this->call(UsersTableSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(UserSeeder::class);
        */
        
        $this->call([
            ProfessionSeeder::class,
            SkillSeeder::class,
            UserSeeder::class
        ]);
    }

    protected function truncateTable(array $tables)
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
        	DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
