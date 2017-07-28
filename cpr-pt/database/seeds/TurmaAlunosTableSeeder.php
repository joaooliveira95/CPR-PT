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
                'idUser' => 1,
                'idTurma' => 3
            ]);

            foreach (App\User::all() as $user) {
               TurmaAluno::firstOrCreate(
                  ['idUser'=> $user->id,
                  'idTurma' => rand(1,3)]
               );
            }

        }
    }
}
