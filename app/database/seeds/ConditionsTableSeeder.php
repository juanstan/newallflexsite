<?php

class ConditionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('conditions')->delete();
        
		\DB::table('conditions')->insert(array (
			1 =>
			array (
				'id' => 1,
				'name' => 'Allergic Dermatitis or other Skin Condition',
			),
			2 => 
			array (
				'id' => 2,
				'name' => 'Arthritis and Joint Pain',
			),
			3 => 
			array (
				'id' => 3,
				'name' => 'Behavioral Changes & Alertness Changes',
			),
			4 => 
			array (
				'id' => 4,
				'name' => 'Cancer',
			),
			5 => 
			array (
				'id' => 5,
				'name' => 'Dental Disease',
			),
			6 => 
			array (
				'id' => 6,
				'name' => 'Diabetes Mellitus',
			),
			7 => 
			array (
				'id' => 7,
				'name' => 'Hypothyroidism',
			),
			8 => 
			array (
				'id' => 8,
				'name' => 'Cushing’s Syndrome',
			),
			9 => 
			array (
				'id' => 9,
				'name' => 'Addison’s Disease',
			),
			10 => 
			array (
				'id' => 10,
				'name' => 'Food Allergy or Food Intolerance',
			),
			11 => 
			array (
				'id' => 11,
				'name' => 'Gastrointestinal or Digestive Disorder',
			),
			12 => 
			array (
				'id' => 12,
				'name' => 'Heart Disease',
			),
			13 => 
			array (
				'id' => 13,
				'name' => 'Kidney Disease',
			),
			14 => 
			array (
				'id' => 14,
				'name' => 'Liver Disease',
			),
			15 => 
			array (
				'id' => 15,
				'name' => 'Urinary Bladder Stones',
			),
			16 => 
			array (
				'id' => 16,
				'name' => 'Incontinence',
			),
			17 => 
			array (
				'id' => 17,
				'name' => 'Previous Accident',
			),
			18 => 
			array (
				'id' => 18,
				'name' => 'Recent Surgery',
			),
			19 => 
			array (
				'id' => 19,
				'name' => ') Nervous System Disorder',
			),
			20 =>
			array (
				'id' => 20,
				'name' => 'Bone or Muscular Disorder',
			),
			21 =>
			array (
				'id' => 21,
				'name' => 'Eye Condition',
			),
			22 =>
			array (
				'id' => 22,
				'name' => 'Recurrent Ear infections',
			),
			23 =>
			array (
				'id' => 23,
				'name' => 'Tooth Problems',
			),
		));
	}

}
