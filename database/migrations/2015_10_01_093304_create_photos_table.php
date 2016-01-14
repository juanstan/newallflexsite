<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function(Blueprint $table)
        {
            $table->integer('id', true, true);
            $table->string('title')->nullable();
            $table->text('location', 65535)->nullable();
            $table->integer('uploading_user_id')->nullable()->unsigned()->index();
            $table->integer('uploading_vet_id')->nullable()->unsigned()->index();
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
        Schema::drop('photos');
    }
}
