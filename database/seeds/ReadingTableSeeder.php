<?php

use Illuminate\Database\Seeder;

class ReadingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('readings')->delete();

        \DB::table('readings')->insert([
            'average' => str_random(2),
            'microchip_id' => 333,
            'temperature' => 50,
            'device_id' => 1,
            'pet_id'    => 1,
            'vet_id'    => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
