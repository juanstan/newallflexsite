<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensorReadingSymptomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sensor_reading_symptoms', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('reading_id')->nullable();
			$table->integer('symptom_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sensor_reading_symptoms');
	}

}
