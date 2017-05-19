<?php

use Illuminate\Database\Seeder;
use App\Sensor;

class SensorsTableSeeder extends Seeder{

    public function run()
    {
        if (Sensor::count() == 0) {

            Sensor::create([
                'id' => 1,
                'name'  => 'hands_pos',
                'info' => 'Sensor that measures hand position accuracy',
                'units' => 'U'
            ]);

            Sensor::create([
                'id' => 2,
                'name'  => 'compress_rate',
                'info' => 'Sensor that measures compression ...',
                'units' => 'U'
            ]);

            Sensor::create([
                'id' => 3,
                'name'  => 'chest_recoil',
                'info' => 'Sensor that measures chest recoil ...',
                'units' => 'U'
            ]);
        }
    }
}
