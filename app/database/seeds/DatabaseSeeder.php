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

        $this->call('VetsTableSeeder');
		$this->call('SymptomsTableSeeder');
		$this->call('ConditionsTableSeeder');
		$this->call('BreedsTableSeeder');
	}

}

