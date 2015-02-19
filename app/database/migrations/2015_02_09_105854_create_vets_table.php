<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vets', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('company_name')->nullable();
			$table->string('contact_name')->nullable();
			$table->string('email_address')->nullable();
			$table->string('telephone')->nullable();
			$table->string('address_1')->nullable();
			$table->string('address_2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('county')->nullable();
			$table->string('zip')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->string('image_path')->nullable();
			$table->string('password')->nullable();
			$table->timestamps();
			$table->integer('access')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vets');
	}

}
