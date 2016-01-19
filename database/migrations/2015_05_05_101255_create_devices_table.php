<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->string('serial_id')->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('vet_id')->unsigned()->nullable();
			$table->string('device')->nullable();
			$table->string('name')->nullable();
			$table->string('version')->nullable();
			$table->timestamps();
			$table->string('field_1')->nullable();
			$table->string('field_2')->nullable();
			$table->string('field_3')->nullable();
			$table->string('field_4')->nullable();
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devices');

	}

}
