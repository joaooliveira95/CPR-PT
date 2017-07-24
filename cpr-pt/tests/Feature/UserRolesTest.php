<?php

namespace Tests\Feature;

use App\User;
use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersRolesTest extends TestCase
{

   use DatabaseMigrations;
   use DatabaseTransactions;

   private function assertRole($id, $role){
      $found_role=Role::find($id);
      $this->assertDatabaseHas('roles', [
         'name' => $role->name,
         'display_name' => $role->display_name
     ]);

      $this->assertEquals($found_role->name, $role->name);
      $this->assertEquals($found_role->display_name, $role->display_name);
      $this->assertEquals($found_role->id, $role->id);
   }

   private function assertUser($id, $user, $role){

      $found_user=User::find($id);
      $this->assertDatabaseHas('users', [
         'name' => $user->name,
         'email' => $user->email,
         'role_id' => $role->id,
     ]);

      $this->assertEquals($found_user->name, $user->name);
      $this->assertEquals($found_user->email, $user->email);
      $this->assertEquals($found_user->id, $user->id);
      $this->assertEquals($found_user->role_id, $user->role_id);
      $this->assertEquals($found_user->role_id, $role->id);
   }


   public function testRolesCreate(){
      $role1 = Role::create([
        'name'=>'admin',
        'display_name'=>'Administrator',
      ]);

      $role2 = Role::create([
        'name'=>'user',
        'display_name'=>'Normal User',
      ]);

      $role3 = Role::create([
        'name'=>'teacher',
        'display_name'=>'Teacher',
      ]);

      $this->assertRole(1, $role1);
      $this->assertRole(2, $role2);
      $this->assertRole(3, $role3);
   }

    public function testUserCreate()
    {

      $role1 = Role::create([
        'name'=>'admin',
        'display_name'=>'Administrator',
      ]);

      $user1 = factory(User::class)->create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => $role1->id,
      ]);

      $this->assertRole(1, $role1);
      $this->assertUser(1, $user1, $role1);
  }

  public function testUserRoleRelationship(){
    $role1 = Role::create([
        'name'=>'admin',
        'display_name'=>'Administrator',
      ]);

      $user1 = factory(User::class)->create([
         'name' => 'John Doe',
         'email' => 'john@example.com',
         'password' => bcrypt('password'),
         'role_id' => $role1->id,
      ]);

      $user2 = factory(User::class)->create([
         'name' => 'Frank Sinatra',
         'email' => 'frank@sinatra.com',
         'password' => bcrypt('password'),
         'role_id' => $role1->id,
      ]);

      $user3 = factory(User::class)->create([
         'name' => 'Janis Joplin',
         'email' => 'janis@joplin.com',
         'password' => bcrypt('password'),
         'role_id' => $role1->id,
      ]);

      $this->assertRole(1, $role1);
      $this->assertUser(1, $user1, $role1);
      $this->assertUser(2, $user2, $role1);
      $this->assertUser(3, $user3, $role1);
  }



}
