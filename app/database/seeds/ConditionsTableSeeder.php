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
			0 => 
			array (
				'id' => 1,
				'name' => 'None',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Allergic Dermatitis or other Skin Condition',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Arthritis and Joint Pain',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Behavioral Changes & Alertness Changes',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Cancer',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Dental Disease',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Diabetes Mellitus',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Hypothyroidism',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Cushing’s Syndrome',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Addison’s Disease',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Food Allergy or Food Intolerance',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'Gastrointestinal or Digestive Disorder',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'Heart Disease',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'Kidney Disease',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'Liver Disease',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'Urinary Bladder Stones',
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'Incontinence',
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'Previous Accident',
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'Recent Surgery',
			),
			19 => 
			array (
				'id' => 20,
			'name' => ') Nervous System Disorder',
		),
		20 => 
		array (
			'id' => 21,
			'name' => 'Bone or Muscular Disorder',
		),
		21 => 
		array (
			'id' => 22,
			'name' => 'Eye Condition',
		),
		22 => 
		array (
			'id' => 23,
			'name' => 'Recurrent Ear infections',
		),
		23 => 
		array (
			'id' => 24,
			'name' => 'Tooth Problems',
		),
	));
	}

}
