<?php

use Illuminate\Database\Seeder;
use App\TurmaAluno;

class TurmaAlunosTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (TurmaAluno::count() == 0) {

            TurmaAluno::create([
                'idUser' => 1,
                'idTurma' => 1
            ]);

            TurmaAluno::create([
                'idUser' => 1,
                'idTurma' => 2
            ]);

            TurmaAluno::create([
                'idUser' => 2,
                'idTurma' => 1
            ]);

            TurmaAluno::create([
                'idUser' => 3,
                'idTurma' => 2
            ]);

            TurmaAluno::create([
                'idUser' => 4,
                'idTurma' => 2
            ]);


            TurmaAluno::create([
                'idUser' => 5,
                'idTurma' => 1
            ]);

            TurmaAluno::create([
                'idUser' => 5,
                'idTurma' => 2
            ]);
        }
    }
}
