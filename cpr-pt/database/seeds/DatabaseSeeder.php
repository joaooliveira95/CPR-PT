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
         $this->call(RolesTableSeeder::class);
         $this->call(NewUsersTableSeeder::class);
         $this->call(SessionsTableSeeder::class);
         $this->call(TurmasTableSeeder::class);
         $this->call(TurmaAlunosTableSeeder::class);
         $this->call(MediaCategoriesTableSeeder::class);
         $this->call(MediaTableSeeder::class);
         $this->call(VoyagerDatabaseSeeder::class);

    }
}
