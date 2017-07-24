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
