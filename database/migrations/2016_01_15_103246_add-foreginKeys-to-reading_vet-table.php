<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToReadingVetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reading_vet', function (Blueprint $table) {
            $table->foreign('reading_id')->references('id')->on('readings')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('vet_id')->references('id')->on('vets')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('reading_vet', function (Blueprint $table) {
            $table->dropForeign('reading_vet_reading_id_foreign');
            $table->dropForeign('reading_vet_vet_id_foreign');
        });*/
    }
}
