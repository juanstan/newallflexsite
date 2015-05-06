<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('SymtomTableSeeder');
	}

}

class SymtomTableSeeder extends Seeder {

    public function run()
    {
        //delete users table records
        DB::table('symptoms')->delete();
        //insert some dummy records
        DB::table('symptoms')->insert(array(
            array('name'=>'Exercise Intolerance'),
            array('name'=>'Difficulty Walking/rising/jumping'),
            array('name'=>'Enlarged Lymph Nodes'),
            array('name'=>'Exercise Intolerance'),
            array('name'=>'Fever'),
            array('name'=>'Itching/scratching'),
            array('name'=>'Limping'),
            array('name'=>'Muscle Atrophy'),
            array('name'=>'Pain'),
            array('name'=>'Shaking'),
            array('name'=>'Stiffness'),
            array('name'=>'Swelling'),
        ));
    }

}
