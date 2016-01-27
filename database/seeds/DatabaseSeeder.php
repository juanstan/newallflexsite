<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
		$this->call('UserTableSeeder');
		$this->call('PetTableSeeder');
		$this->call('PetVetTableSeeder');
		$this->call('DeviceTableSeeder');
		$this->call('ReadingTableSeeder');
		$this->call('ReadingSymptomTableSeeder');
		$this->call('ConditionPetTableSeeder');

	}
}

