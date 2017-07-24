<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{

   use DatabaseMigrations;
   use DatabaseTransactions;


    public function testUserCreate()
    {
      $user = factory(User::class)->create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
     ]);

      $found_user=User::find(1);
      $this->assertDatabaseHas('users', [
         'name' => 'John Doe',
         'email' => 'john@example.com',
     ]);

      $this->assertEquals($found_user->name, 'John Doe');
      $this->assertEquals($found_user->email, 'john@example.com');
      $this->assertEquals($found_user->id, 1);

      $this->assertEquals($found_user->name, $user->name);
      $this->assertEquals($found_user->email, $user->email);
      $this->assertEquals($found_user->id, $user->id);
  }



}
