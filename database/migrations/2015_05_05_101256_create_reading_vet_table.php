<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReadingVetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reading_vet', function(Blueprint $table)
		{
			$table->integer('reading_id')->unsigned();
			$table->integer('vet_id')->unsigned();
			$table->primary(['reading_id','vet_id']);
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
		//Schema::drop('reading_vet');
	}

}
