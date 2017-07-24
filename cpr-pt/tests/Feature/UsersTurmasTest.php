<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Turma;
use App\TurmaAluno;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTurmasTest extends TestCase
{
   use DatabaseMigrations;
   use DatabaseTransactions;

    private function assertUser($id, $user){

      $found_user=User::find($id);
      $this->assertDatabaseHas('users', [
         'name' => $user->name,
         'email' => $user->email,
         'role_id' => $user->role_id,
     ]);

      $this->assertEquals($found_user->name, $user->name);
      $this->assertEquals($found_user->email, $user->email);
      $this->assertEquals($found_user->id, $user->id);
      $this->assertEquals($found_user->role_id, $user->role_id);
   }


   private function assertTurma($id, $turma){

      $found_turma=Turma::find($id);
      $this->assertDatabaseHas('turmas', [
         'name' => $turma->name,
     ]);

      $this->assertEquals($found_turma->name, $turma->name);
      $this->assertEquals($found_turma->id, $turma->id);
   }

    private function assertTurmaAluno($id, $turmaAluno, $turma, $user){

      $found_turmaAluno=TurmaAluno::find($id);
      $this->assertDatabaseHas('turma_alunos', [
         'idUser' => $user->id,
         'idTurma' =>$turma->id
     ]);

      $this->assertEquals($found_turmaAluno->id, $id);
      $this->assertEquals($found_turmaAluno->idUser, $user->id);
      $this->assertEquals($found_turmaAluno->idTurma, $turma->id);
   }


    public function testTurmaCreate()
    {
    	$turma1 = Turma::create([
	        'name'=>'Turma A',
     	]);

     	$turma2 = Turma::create([
	        'name'=>'Turma B',
     	]);


    	$turma3 = Turma::create([
	        'name'=>'Turma C',
     	]);


		$this->assertTurma(1, $turma1);
		$this->assertTurma(2, $turma2);
		$this->assertTurma(3, $turma3);
    }

    public function testTurmaAlunoCreate(){
    	$user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      	]);

    	$turma1 = Turma::create([
	        'name'=>'Turma A',
     	]);

     	$tumaAluno1 = TurmaAluno::create([
     		'idUser' => $user1->id,
     		'idTurma' => $turma1->id,
     	]);

		$this->assertUser(1, $user1);
		$this->assertTurma(1, $turma1);
		$this->assertTurmaAluno(1, $tumaAluno1, $turma1, $user1);
    }

    public function testTurmaAlunosRelationship(){

    	$user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      	]);

	      $user2 =  User::create([
	         'name' => 'Frank Sinatra',
	         'email' => 'frank@sinatra.com',
	         'password' => bcrypt('password'),
	         'role_id' => 1,
	      ]);


    	$turma1 = Turma::create([
	        'name'=>'Turma A',
     	]);

     	$turma2 = Turma::create([
	        'name'=>'Turma B',
     	]);

     	//Turmas John Doe
     	$tumaAluno1 = TurmaAluno::create([
     		'idUser' => $user1->id,
     		'idTurma' => $turma1->id,
     	]);

     	$tumaAluno2 = TurmaAluno::create([
     		'idUser' => $user1->id,
     		'idTurma' => $turma2->id,
     	]);

     	//Turmas Frank Sinatra
     	$tumaAluno3 = TurmaAluno::create([
     		'idUser' => $user2->id,
     		'idTurma' => $turma1->id,
     	]);

     	$tumaAluno4 = TurmaAluno::create([
     		'idUser' => $user2->id,
     		'idTurma' => $turma2->id,
     	]);

     	$this->assertUser(1, $user1);
		$this->assertTurma(1, $turma1);

     	$this->assertUser(2, $user2);
		$this->assertTurma(2, $turma2);

		$this->assertTurmaAluno(1, $tumaAluno1, $turma1, $user1);
		$this->assertTurmaAluno(2, $tumaAluno2, $turma2, $user1);

		$this->assertTurmaAluno(3, $tumaAluno3, $turma1, $user2);
		$this->assertTurmaAluno(4, $tumaAluno4, $turma2, $user2);
    }
}
