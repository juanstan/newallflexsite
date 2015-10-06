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
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('location', 65535)->nullable();
            $table->integer('uploading_user_id')->unsigned()->nullable()->index('`ndx_photos_uploading_user_id`');
            $table->integer('uploading_vet_id')->unsigned()->nullable()->index('`ndx_photos_uploading_vet_id`');
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
