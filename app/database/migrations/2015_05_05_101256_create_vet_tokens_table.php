<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVetTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vet_tokens', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vet_id')->nullable();
			$table->string('token')->nullable();
			$table->integer('device_id')->nullable();
			$table->softDeletes();
			$table->dateTime('expires_at')->nullable();
			$table->dateTime('last_accessed_at')->nullable();
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
		Schema::drop('vet_tokens');
	}

}
