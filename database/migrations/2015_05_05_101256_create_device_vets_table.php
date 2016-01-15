<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceVetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('device_vet', function(Blueprint $table)
		{
			$table->integer('vet_id')->unsigned();
			$table->integer('device_id')->unsigned();
			$table->primary(array('vet_id','device_id'));
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
		Schema::drop('device_vet');
	}

}
