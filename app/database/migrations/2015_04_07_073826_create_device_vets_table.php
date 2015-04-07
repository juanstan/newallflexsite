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
		Schema::create('device_vets', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vet_id')->nullable();
			$table->integer('device_id')->nullable();
			$table->dateTime('created_at')->nullable();
			$table->time('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('device_vets');
	}

}
