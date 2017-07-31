<?php

use Illuminate\Database\Seeder;
use App\Session;
use App\Exercise;

class SessionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (Session::count() == 0) {

            foreach (App\User::all() as $user) {
               if($user->name!='Admin'){
               for($i=0; $i<rand(2,5); $i++){
                  $session = Session::create([
                    'title' => 'title'.$i,
                     'idUser'=> $user->id,
                  ]);

                  for($i=0; $i<rand(1,5); $i++){
                     Exercise::create([
                        'idSession'=>$session->id,
                        'time'=>rand(1000, 20000),
                        'recoil'=>rand(0,100),
                        'compressions'=>rand(20,140),
                        'hand_position'=>rand(0,100),
                        ]);
                     }
                  }
               }
            }



        }
    }
}
