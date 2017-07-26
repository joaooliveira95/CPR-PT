<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Turma;
use App\TurmaAluno;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TurmasControllerTest extends TestCase
{
   use DatabaseMigrations;
   use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    private function createUser($name, $email, $role){
      $user1 = User::create([
          'name' => $name,
          'email' => $email,
          'password' => bcrypt('password'),
          'role_id' => $role, //ADMIN
      ]);
      return $user1;
   }

   private function addUserToTurma($idUser, $idTurma){
      $turmaAluno = TurmaAluno::create([
         'idUser' => $idUser,
         'idTurma' =>$idTurma,
      ]);
      return $turmaAluno;
   }

    //0 Estudantes, 1 Professor
    public function testNumberStudents(){
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $turma1 = Turma::create([
         'name' => 'Turma 1',
      ]);

      $turmaAluno1 = $this->addUserToTurma($user1->id, $turma1->id);

      $this->actingAs($user1);
      $response = $this->call('POST', 'n_alunos/'.$turma1->id);

      $json =  json_decode($response->getContent());
      $this->assertEquals(0, $json['n_students']);

    }


    public function testNumberStudents1(){

   }

    public function testTurmas(){
      //ROLE = PROFESSOR
      $user1 = $this->createUser('John Doe','john@example.com', 3);

      $this->actingAs($user1);
      $response = $this->call('GET', 'turmas/');
      $view= $response->original;
   }

   public function testStudentsIndex(){
      $user1 = $this->createUser('John Doe','john@example.com', 1);
      $user2 = $this->createUser('Jimi Hendrix','jimi@hendrix.com', 2);
      $user3 = $this->createUser('Frank Sinatra','frank@sinatra.com', 2);

      $turma1 = Turma::create([
         'name' => 'Turma 1',
      ]);

      $turmaAluno1 = $this->addUserToTurma($user1->id, $turma1->id);

      $this->actingAs($user1);
      $response = $this->call('GET', 'turma/'.$turma1->id);
      $view= $response->original;

      $students = $view['students'];
      $this->assertEquals(0, $students->count());

      $turmaAluno2 = $this->addUserToTurma($user2->id, $turma1->id);
      $turmaAluno3 = $this->addUserToTurma($user3->id, $turma1->id);

      $response = $this->call('GET', 'turma/'.$turma1->id);
      $view= $response->original;

      $students = $view['students'];
      $this->assertEquals(2, $students->count());
      $this->assertEquals($user2->id, $students->first()->id);
      $this->assertEquals($user2->email, $students->first()->email);
   }
}
