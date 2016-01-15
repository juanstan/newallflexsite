<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToReadingSymptomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reading_symptom', function (Blueprint $table) {
            $table->foreign('reading_id')->references('id')->on('readings')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('symptom_id')->references('id')->on('symptoms')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reading_symptom', function (Blueprint $table) {
            $table->dropForeign('reading_symptom_reading_id_foreign');
            $table->dropForeign('reading_symptom_symptom_id_foreign');
        });
    }
}
