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
		Schema::create('sensor_reading_symptom', function(Blueprint $table)
		{
			$table->integer('reading_id')->unsigned()->index();
			$table->foreign('reading_id')->references('id')->on('sensor_readings')->onDelete('cascade');
			$table->integer('symptom_id')->unsigned()->index();
			$table->foreign('symptom_id')->references('id')->on('symptoms')->onDelete('cascade');
			$table->primary(array('reading_id','symptom_id'));
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sensor_reading_symptom');
	}

}
