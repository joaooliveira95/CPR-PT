<?php

use Illuminate\Database\Seeder;
use App\Session;

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

            Session::create([
                'id' => 1,
                'idUser' => 1,
                'title' => 'Test'
            ]);
        }
    }
}
