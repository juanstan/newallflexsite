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
			$table->string('breed')->nullable();
			$table->integer('age')->nullable();
			$table->float('weight', 10, 0)->nullable();
			$table->text('size')->nullable();
			$table->string('gender')->nullable();
			$table->string('image_path')->nullable();
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
