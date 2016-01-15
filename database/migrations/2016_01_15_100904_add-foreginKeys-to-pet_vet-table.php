<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToPetVetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_vet', function (Blueprint $table) {
            $table->foreign('pet_id')->references('id')->on('pets')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('vet_id')->references('id')->on('vets')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_vet', function (Blueprint $table) {
            $table->dropForeign('pet_vet_pet_id_foreign');
            $table->dropForeign('pet_vet_vet_id_foreign');
        });
    }
}
