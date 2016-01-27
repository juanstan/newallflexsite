<?php

use Illuminate\Database\Seeder;

class ReadingSymptomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('reading_symptom')->delete();
        \DB::table('reading_symptom')->insert([
            1 =>
                array (
                    'reading_id' => 1,
                    'symptom_id' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            2 =>
                array (
                    'reading_id' => 1,
                    'symptom_id' => 5,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            3 =>
                array (
                    'reading_id' => 1,
                    'symptom_id' => 8,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
            4 =>
                array (
                    'reading_id' => 1,
                    'symptom_id' => 10,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                )
        ]);
    }
}
