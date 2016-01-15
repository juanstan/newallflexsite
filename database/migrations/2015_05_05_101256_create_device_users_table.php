<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('device_user', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('device_id')->unsigned();
			$table->primary(array('user_id','device_id'));
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
		Schema::drop('device_user');
	}

}
