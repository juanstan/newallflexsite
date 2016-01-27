<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableReadingVet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reading_vet', function (Blueprint $table) {
            $table->drop();
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
            $table->integer('reading_id')->unsigned();
            $table->integer('vet_id')->unsigned();
            $table->primary(['reading_id', 'vet_id']);
            $table->timestamps();
            $table->foreign('reading_id')->references('id')->on('readings')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('vet_id')->references('id')->on('vets')->onUpdate('restrict')->onDelete('restrict');
        });*/
    }
}
