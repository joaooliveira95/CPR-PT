<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Session;
use App\Exercise;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionsControllerTest extends TestCase
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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSessions()
    {
         $user1 = $this->createUser('John Doe','john@example.com', 1);

         $session1 = Session::create([
           'title' => 'title1',
             'idUser'=> $user1->id,
         ]);

         $session2 = Session::create([
           'title' => 'title2',
             'idUser'=> $user1->id,
         ]);

         $this->actingAs($user1);
         $response = $this->call('GET', 'sessions/'.$user1->id);

         $view= $response->original;
         $this->assertEquals($user1->id, $view['user']->id);

         $sessions_view = $view['sessions'];
         $this->assertEquals(Session::where('idUser', $session1->idUser)->count(), $sessions_view->count());

         foreach ($sessions_view as $session) {
            $session_test = Session::where('id', $session->id)->first();
            $this->assertEquals($session->id, $session_test->id);
            $this->assertEquals($session->title, $session_test->title);
         }

    }

    public function testSession(){
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $session1 = Session::create([
        'title' => 'title1',
          'idUser'=> $user1->id,
      ]);

      $exercise1 = $this->createExercise($session1->id);
      $exercise2 = $this->createExercise($session1->id);

      $this->actingAs($user1);
      $response = $this->call('GET', 'sessions/session/'.$session1->id);

      $view= $response->original;
      $this->assertEquals($user1->id, $view['user']->id);
      $this->assertEquals($user1->email, $view['user']->email);

      $this->assertEquals($session1->id, $view['session']->id);
      $this->assertEquals($session1->title, $view['session']->title);

      $exercises_view = $view['exercises'];
      $this->assertEquals($exercises_view->count(), Exercise::where('idSession', $session1->id)->count());

      foreach ($exercises_view as $exercise) {
         $exercise_test = Exercise::where('id', $exercise->id)->first();
         $this->assertEquals($exercise->id, $exercise_test->id);
         $this->assertEquals($exercise->created_at, $exercise_test->created_at);

         $this->assertEquals($exercise->time, $exercise_test->time);
         $this->assertEquals($exercise->recoil, $exercise_test->recoil);
         $this->assertEquals($exercise->compressions, $exercise_test->compressions);
         $this->assertEquals($exercise->hand_position, $exercise_test->hand_position);
      }
   }

   public function testExercise(){
      $user1 = $this->createUser('John Doe','john@example.com', 1);

      $session1 = Session::create([
        'title' => 'title1',
          'idUser'=> $user1->id,
      ]);

      $exercise1 = $this->createExercise($session1->id);

      $this->actingAs($user1);
      $response = $this->call('GET', 'exercise_results/'.$exercise1->id);

      $view= $response->original;
      $exercise_view = $view['exercise'];
      $this->assertEquals($exercise_view->id, $exercise1->id);
      $this->assertEquals($exercise_view->created_at, $exercise1->created_at);

   }

   public function testProgress(){

   }

   public function testUserExercises(){

   }
}
