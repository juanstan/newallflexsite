<?php

use Illuminate\Database\Seeder;

class ConditionPetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('condition_pet')->delete();
        \DB::table('condition_pet')->insert([
            1 =>
                array (
                    'pet_id' => 1,
                    'condition_id' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            2 =>
                array (
                    'pet_id' => 1,
                    'condition_id' => 5,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            3 =>
                array (
                    'pet_id' => 1,
                    'condition_id' => 8,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            4 =>
                array (
                    'pet_id' => 1,
                    'condition_id' => 10,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                )
        ]);
    }
}
