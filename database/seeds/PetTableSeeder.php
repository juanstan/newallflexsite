<?php

use Illuminate\Database\Seeder;


class PetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        \DB::table('pets')->delete();

        \DB::table('pets')->insert([
            'name' => str_random(10),
            'microchip_number' => str_random(10),
            'breed_id' => 5,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
