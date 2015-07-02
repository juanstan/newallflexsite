<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SymptomsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('symptoms')->delete();
        
		\DB::table('symptoms')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'All looks normal',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Itching/Scratching',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Hair Loss',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Diarrhea',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Vomiting',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Drooling',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Urinating a lot or Urine loss',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Restless',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Changed appetite',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Increased eating / Abnormal eating',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Increased head shaking',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'Change in odor',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'Weight loss',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'Abnormal behavior',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'Not playful',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'Abnormal movement',
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'Limping',
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'Overall poor appearance',
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'Dull Coat',
			),
			19 => 
			array (
				'id' => 20,
				'name' => 'Drinking a lot',
			),
			20 => 
			array (
				'id' => 21,
				'name' => 'Bleeding',
			),
			21 => 
			array (
				'id' => 22,
				'name' => 'Looks pale',
			),
			22 => 
			array (
				'id' => 23,
				'name' => 'Change in bark',
			),
		));
	}

}
