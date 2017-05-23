<?php

use Illuminate\Database\Seeder;
use App\Turma;

class TurmasTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (Turma::count() == 0) {

            Turma::create([
                'id' => 1,
                'name' => 'Turma A'
            ]);

            Turma::create([
                'id' => 2,
                'name' => 'Turma B'
            ]);
        }
    }
}
