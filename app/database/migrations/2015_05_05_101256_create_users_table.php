<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email_address')->nullable();
			$table->string('telephone')->nullable();
			$table->string('units')->nullable();
			$table->string('image_path')->nullable();
			$table->string('password')->nullable();
			$table->timestamps();
			$table->integer('access')->default(1);
			$table->string('remember_token', 100)->nullable();
			$table->string('confirmation_code')->nullable();
			$table->integer('confirmed')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
