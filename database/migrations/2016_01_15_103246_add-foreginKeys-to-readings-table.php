<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('readings', function (Blueprint $table) {
            $table->foreign('device_id')->references('id')->on('devices')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('readings', function (Blueprint $table) {
            $table->dropForeign('readings_pet_id_foreign');
            $table->dropForeign('readings_device_id_foreign');
        });
    }
}
