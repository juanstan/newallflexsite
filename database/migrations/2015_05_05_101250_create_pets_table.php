<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pets', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->string('name')->nullable();
			$table->string('microchip_number')->nullable();
			$table->integer('breed_id')->nullable();
			$table->string('breed_wildcard')->nullable();
			$table->integer('photo_id')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->text('weight', 65535)->nullable();
			$table->tinyInteger('gender')->nullable();
			$table->integer('vet_id')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('pets');
	}

}
