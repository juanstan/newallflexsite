<?php

use Illuminate\Database\Seeder;


class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('devices')->delete();

        \DB::table('devices')->insert([
            'serial_id' => str_random(10),
            'user_id' => 1,
            'device' => 'first device',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
