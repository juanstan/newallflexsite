<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToDeviceVetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_vet', function (Blueprint $table) {
            $table->foreign('vet_id')->references('id')->on('vets')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_vet', function (Blueprint $table) {
            $table->dropForeign('device_vet_vet_id_foreign');
            $table->dropForeign('device_vet_device_id_foreign');
        });
    }
}
