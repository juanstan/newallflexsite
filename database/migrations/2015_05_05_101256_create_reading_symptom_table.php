<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReadingSymptomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reading_symptom', function(Blueprint $table)
		{
			$table->integer('reading_id')->unsigned();
			$table->integer('symptom_id')->unsigned();
			$table->primary(array('reading_id','symptom_id'));
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
		Schema::drop('reading_symptom');
	}

}
