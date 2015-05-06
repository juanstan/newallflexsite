<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnimalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('animals', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->nullable();
			$table->string('microchip_number')->nullable();
			$table->integer('breed_id')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->float('weight', 10, 0)->nullable();
			$table->text('size', 65535)->nullable();
			$table->string('gender')->nullable();
			$table->string('image_path')->nullable();
			$table->integer('vet_id')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('animals');
	}

}
