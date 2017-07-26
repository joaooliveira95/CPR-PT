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
    /**
     * A basic test example.
     *
     * @return void
     */

      //Sem exercicios em branco
   public function testEndSession(){
      $user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      ]);
      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $exercise1 = Exercise::create([
         'idSession'=>$session1->id,
         'time'=>20000,
         'recoil'=>90,
         'compressions'=>66,
         'hand_position'=>77,
      ]);

      $this->actingAs($user1);
      $response = $this->call('POST', 'endSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 1);

      $view= $response->original;
      $response->assertRedirect('/sessions/session/'.$session1->id);
   }

      //Com exercicios em branco
   public function testEndSession2(){
      $user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      ]);
      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $exercise1 = Exercise::create([
         'idSession'=>$session1->id,
         'time'=>20000,
         'recoil'=>90,
         'compressions'=>66,
         'hand_position'=>77,
      ]);

      $exercise2 = Exercise::create([
         'idSession'=>$session1->id,
         'time'=>0,
         'recoil'=>90,
         'compressions'=>66,
         'hand_position'=>77,
      ]);

      $exercise3 = Exercise::create([
         'idSession'=>$session1->id,
         'time'=>0,
         'recoil'=>90,
         'compressions'=>66,
         'hand_position'=>77,
      ]);

      $this->actingAs($user1);
      $response = $this->call('POST', 'endSession/'.$session1->id);

      $count = Exercise::where('idSession', $session1->id)->count();
      $this->assertEquals($count, 1);

      $view= $response->original;
      $response->assertRedirect('/sessions/session/'.$session1->id);
   }

      //Sessao em branco
   public function testEndSession3(){
      $user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      ]);
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
      $user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      ]);

      $this->actingAs($user1);
      $response = $this->call('POST', 'startSession/', ['title'=>'Titulando']);

      $count_session = Session::where('idUser', $user1->id)->count();
      $this->assertEquals($count_session, 1);

      $idSession = Session::where('idUser', $user1->id)->first()->id;
      $count_exercise =  Exercise::where('idSession', $idSession)->count();
      $this->assertEquals($count_exercise, 1);
      $exercise = Session::where('idUser', $user1->id)->first();
      $idExercise= $exercise->id;

      $this->assertEquals($idSession, 1);
      $this->assertEquals($idExercise, 1);
      $this->assertEquals($exercise->time, 0);

      $view= $response->original;
      $this->assertEquals($idSession, $view['id']);
      $this->assertEquals($idExercise, $view['curExercise']);
   }

   public function testNextSession(){
      $user1 = User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => 1,
      ]);

      $session1 = Session::create([
        'title' => 'title1',
         'idUser'=> $user1->id,
      ]);

      $exercise1 = Exercise::create([
     		'idSession'=>$session1->id,
     		'time'=>20000,
     		'recoil'=>90,
     		'compressions'=>66,
     		'hand_position'=>77,
     	]);

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
      $user1 = User::create([
       'name' => 'John Doe',
       'email' => 'john@example.com',
       'password' => bcrypt('password'),
       'role_id' => 1,
      ]);
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

    public function testWrongLastSession()
  {
     $user1 = User::create([
      'name' => 'John Doe',
      'email' => 'john@example.com',
      'password' => bcrypt('password'),
      'role_id' => 1,
     ]);

     $this->actingAs($user1);
     $response = $this->call('GET', '/lastSession');
     $response->assertRedirect('/newSession');
  }


}
