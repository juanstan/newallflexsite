<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnimalRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('animal_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vet_id')->nullable();
			$table->integer('approved')->nullable();
			$table->integer('request_type')->nullable();
			$table->text('request_reason')->nullable();
			$table->text('response_reason')->nullable();
			$table->integer('expiry_type')->nullable();
			$table->integer('expiry_days')->nullable();
			$table->timestamps();
			$table->dateTime('approval_date')->nullable();
			$table->dateTime('expiry_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('animal_requests');
	}

}
