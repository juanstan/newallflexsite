<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConditionPetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('condition_pet', function(Blueprint $table)
		{

			$table->integer('pet_id')->unsigned();
			$table->integer('condition_id')->unsigned();
			$table->primary(array('condition_id','pet_id'));
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
		Schema::drop('condition_pet');
	}

}
