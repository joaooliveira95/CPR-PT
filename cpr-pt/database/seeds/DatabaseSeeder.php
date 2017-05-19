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
    	$this->call(VoyagerDatabaseSeeder::class);
    	$this->call(VoyagerDummyDatabaseSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(SensorsTableSeeder::class);
        $this->call(TurmasTableSeeder::class);
        $this->call(TurmaAlunosTableSeeder::class);
    }
}
