<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePetVetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pet_vet', function(Blueprint $table)
		{
			$table->integer('vet_id')->unsigned();
			$table->integer('pet_id')->unsigned();
			$table->integer('approved')->nullable()->default(1);
			$table->primary(array('vet_id','pet_id'));
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
		Schema::drop('pet_vet');
	}

}
