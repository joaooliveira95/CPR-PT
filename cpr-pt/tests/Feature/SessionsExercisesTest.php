<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Session;
use App\Exercise;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionsExercises extends TestCase
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

	private function assertSession($id, $session, $user){

      $found_session=Session::find($id);
      $this->assertDatabaseHas('sessions', [
         'idUser' => $user->id,
         'title'=> $session->title,
     ]);

		$this->assertEquals($found_session->id, $session->id);
		$this->assertEquals($found_session->name, $session->name);
		$this->assertEquals($found_session->description, $session->description);
	}

	private function assertExercise($id, $exercise, $session){
		$found_exercise=Exercise::find($id);
		$this->assertDatabaseHas('exercises', [
			'idSession' => $session->id,
			'time'=>$exercise->time,
     		'recoil'=>$exercise->recoil,
     		'compressions'=>$exercise->compressions,
     		'hand_position'=>$exercise->hand_position,
     	]);

		$this->assertEquals($found_exercise->id, $exercise->id);
		$this->assertEquals($found_exercise->idSession, $exercise->idSession);
		$this->assertEquals($found_exercise->time, $exercise->time);
		$this->assertEquals($found_exercise->recoil, $exercise->recoil);
		$this->assertEquals($found_exercise->compressions, $exercise->compressions);
		$this->assertEquals($found_exercise->hand_position, $exercise->hand_position);
		
	}

	public function testSessionCreate(){
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

		$this->assertUser(1, $user1);
     	$this->assertSession(1, $session1, $user1);
	}

	public function testExerciseCreate(){
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

		$this->assertUser(1, $user1);
     	$this->assertSession(1, $session1, $user1);
     	$this->assertExercise(1, $exercise1, $session1);
	}

	public function testSessionUsersRelationship(){
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

		$session1 = Session::create([
	     'title' => 'title1',
         'idUser'=> $user1->id,
     	]);


		$session2 = Session::create([
	     'title' => 'title2',
         'idUser'=> $user1->id,
     	]);

     	$session3 = Session::create([
	     'title' => 'title2',
         'idUser'=> $user2->id,
     	]);


		$this->assertUser(1, $user1);
     	$this->assertSession(1, $session1, $user1);
     	$this->assertSession(2, $session2, $user1);
     	$this->assertSession(3, $session3, $user2);
	}

	public function testSessionExercisesRelationship(){
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
     		'time'=>18000,
     		'recoil'=>90,
     		'compressions'=>66,
     		'hand_position'=>77,
     	]);

     	$exercise2 = Exercise::create([
     		'idSession'=>$session1->id,
     		'time'=>20000,
     		'recoil'=>90,
     		'compressions'=>66,
     		'hand_position'=>77,
     	]);

     	$exercise3 = Exercise::create([
     		'idSession'=>$session1->id,
     		'time'=>22000,
     		'recoil'=>90,
     		'compressions'=>66,
     		'hand_position'=>77,
     	]);

		$this->assertUser(1, $user1);
     	$this->assertSession(1, $session1, $user1);
		$this->assertExercise(1, $exercise1, $session1);
		$this->assertExercise(2, $exercise2, $session1);
		$this->assertExercise(3, $exercise3, $session1);
	}

}
