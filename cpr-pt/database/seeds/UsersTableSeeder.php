<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $admin = Role::where('name', 'admin')->firstOrFail();
             $user = Role::where('name', 'user')->firstOrFail();
              $teacher = Role::where('name', 'teacher')->firstOrFail();


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
        }
    }
}
