<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class NewUsersTableSeeder extends Seeder
{

    public function run()
    {
         $admin = Role::where('name', 'admin')->firstOrFail();
         $user = Role::where('name', 'user')->firstOrFail();
         $teacher = Role::where('name', 'teacher')->firstOrFail();


        if (User::count() == 0) {

            User::create([
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => str_random(60),
                'role_id'        => $admin->id,
            ]);

            User::create([
                'name'           => 'João Oliveira',
                'email'          => 'joaomiguelso@hotmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => str_random(60),
                'role_id'        => $user->id,
            ]);

            User::create([
                'name'           => 'Pedro Marques',
                'email'          => 'pmarques@mail.com',
                'password'       => bcrypt('password'),
                'remember_token' => str_random(60),
                'role_id'        => $teacher->id,
            ]);

            factory(App\User::class,10)->create(
               ['password'=> bcrypt('password'),
               'role_id' => $user->id]
            );


            factory(App\User::class,5)->create(
               ['password'=> bcrypt('password'),
               'role_id' => $teacher->id]
            );

        }
    }
}
