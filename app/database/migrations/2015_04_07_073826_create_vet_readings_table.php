<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVetReadingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vet_readings', function(Blueprint $table)
		{
			$table->integer('reading_id');
			$table->integer('vet_id');
			$table->timestamps();
			$table->primary(['reading_id','vet_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vet_readings');
	}

}
