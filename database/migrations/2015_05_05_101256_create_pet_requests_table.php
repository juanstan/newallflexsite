<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePetRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pet_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vet_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('pet_id')->nullable();
			$table->integer('approved')->nullable()->default(1);
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
		Schema::drop('pet_requests');
	}

}
