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
			$table->integer('id', true, true);
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->string('provider')->nullable();
			$table->string('provider_id')->unique()->nullable();
			$table->integer('photo_id')->unsigned()->index();
			$table->string('telephone')->nullable();
			$table->integer('units')->nullable();
			$table->integer('weight_units')->nullable();
			$table->string('password')->nullable();
			$table->timestamps();
			$table->integer('access')->default(1);
			$table->string('remember_token', 100)->nullable();
			$table->string('confirmation_code')->nullable();
			$table->integer('confirmed')->nullable();
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
		Schema::drop('users');
	}

}
