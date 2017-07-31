<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Session;
use App\Exercise;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewSessionControllerTest extends TestCase
{
   use DatabaseMigrations;
   use DatabaseTransactions;

   private function createUser($name, $email, $role){
     $user1 = User::create([
         'name' => $name,
         'email' => $email,
         'password' => bcrypt('password'),
         'role_id' => $role, //ADMIN
     ]);
     return $user1;
  }

  private function createExercise($idSession){
     return Exercise::create([
         'idSession'=>$idSession,
         'time'=>rand(1, 20000),
         'recoil'=>rand(1,100),
         'compressions'=>rand(1,150),
         'hand_position'=>rand(1,100),
     ]);
  }

  private function createEmptyExercise($idSession){
     return Exercise::create([
         'idSession'=>$idSession,
         'time'=>0,
         'recoil'=>rand(1,100),
         'compressions'=>rand(1,150),
         'hand_position'=>rand(1,100),
     ]);
  }

      //Sem exercicios em branco
   public function testEndSession(){
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $exercise1 = $this->createExercise($session1->id);

      $this->actingAs($user1);
      $response = $this->call('POST', 'endSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 1);

      $view= $response->original;
      $response->assertRedirect('/sessions/session/'.$session1->id);
   }

      //Com exercicios em branco
   public function testEndSession2(){
      $num_emptyExercises = 10;
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 1);
      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);
      //Cria o único exercicio não vazio (com tempo > 0)
      $exercise1 = $this->createExercise($session1->id);

      //Cria exercicios vazios pertencentes a mesma sessao
      for($i=0; $i<$num_emptyExercises; $i++){
         $this->createEmptyExercise($session1->id);
      }

      $this->actingAs($user1);
      $response = $this->call('POST', 'endSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 1);

      $view= $response->original;
      $response->assertRedirect('/sessions/session/'.$session1->id);
   }

      //Sessao em branco
   public function testEndSession3(){
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $this->actingAs($user1);
      $response = $this->call('POST', 'endSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 0);

      $view= $response->original;
      $response->assertRedirect('sessions/'.$user1->id);
   }

   public function testStartSession(){
      $sessions_count = 1;
      $session_title = 'Titulando';

      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 1);
      //Utilizador criado é autenticado
      $this->actingAs($user1);
      //User1 executa um pedido post
      $response = $this->call('POST', 'startSession/', ['title'=>$session_title]);

      $session_query = Session::where('idUser', $user1->id);
      //Valida se é criado apenas 1 sessão, e se a sessão é criada com o nome pretendido
      $this->assertEquals($session_query->count(), $sessions_count);
      $this->assertEquals($session_query->first()->title, $session_title);

      $exercise_query =  Exercise::where('idSession', $session_query->first()->id);
      //Valida se é criado apenas 1 exercicio, e se os seus campos se encontram inicializados a 0
      $this->assertEquals($exercise_query->count(), 1);
      $this->assertEquals($exercise_query->first()->time, 0);
      $this->assertEquals($exercise_query->first()->recoil, 0);
      $this->assertEquals($exercise_query->first()->compressions, 0);
      $this->assertEquals($exercise_query->first()->hand_position, 0);

      $view= $response->original;
      //Valida se a View é carregada com os IDs pretendidos
      $this->assertEquals($session_query->first()->id, $view['id']);
      $this->assertEquals($exercise_query->first()->id, $view['curExercise']);
   }

   public function testNextSession(){
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $exercise1 = $this->createExercise($session1->id);

      $this->actingAs($user1);
      $response = $this->call('POST', 'curSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 2);

      $view= $response->original;
      $this->assertEquals($session1->id, $view['id']);
      $this->assertEquals(2, $view['curExercise']);  //1 por não ter mais exs criados
   }

    public function testCorrectLastSession()
    {
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 3);

      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);
      $session2 = Session::create([
        'title' => 'title2',
         'idUser'=> $user1->id,
      ]);
      $session3 = Session::create([
        'title' => 'title3',
         'idUser'=> $user1->id,
      ]);

      $this->actingAs($user1);
      $response = $this->call('GET', '/lastSession');
      $view= $response->original;
      $this->assertEquals($session3->id, $view['id']);
      $this->assertEquals(1, $view['curExercise']);  //1 por não ter mais exs criados

    }

    public function testWrongLastSession(){
      //Cria um utilizador
      $user1 = $this->createUser('John Doe','john@example.com', 2);

     $this->actingAs($user1);
     $response = $this->call('GET', '/lastSession');
     $response->assertRedirect('/newSession');
  }


}
