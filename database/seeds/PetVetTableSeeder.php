<?php

use Illuminate\Database\Seeder;

class PetVetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pet_vet')->delete();

        \DB::table('pet_vet')->insert([
            'pet_id'    => 1,
            'vet_id'    => 1,
            'approved'    => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
