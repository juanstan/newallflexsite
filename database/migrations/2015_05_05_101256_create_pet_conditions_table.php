<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePetConditionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('condition_pet', function(Blueprint $table)
		{

			$table->integer('pet_id')->unsigned()->index();
			$table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
			$table->integer('condition_id')->unsigned()->index();
			$table->foreign('condition_id')->references('id')->on('conditions')->onDelete('cascade');
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
