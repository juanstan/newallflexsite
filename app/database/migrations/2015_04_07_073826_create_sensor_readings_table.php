<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensorReadingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sensor_readings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('reading_id')->nullable();
			$table->integer('average')->nullable();
			$table->string('microchip_id')->nullable();
			$table->float('temperature', 10, 0)->nullable();
			$table->dateTime('reading_time')->nullable();
			$table->integer('device_id')->nullable();
			$table->integer('animal_id')->nullable();
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
		Schema::drop('sensor_readings');
	}

}
