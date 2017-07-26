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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSessions()
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

         $this->actingAs($user1);
         $response = $this->call('GET', 'sessions/'.$user1->id);

         $view= $response->original;
         $this->assertEquals($user1->id, $view['idUser']);

         $sessions_view = $view['sessions'];
         $this->assertEquals(Session::where('idUser', $session1->idUser)->count(), $sessions_view->count());

         foreach ($sessions_view as $session) {
            $session_test = Session::where('id', $session->id)->first();
            $this->assertEquals($session->id, $session_test->id);
            $this->assertEquals($session->title, $session_test->title);
         }

    }

    public function testSession(){
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
         'time'=>40000,
         'recoil'=>50,
         'compressions'=>16,
         'hand_position'=>27,
      ]);

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
