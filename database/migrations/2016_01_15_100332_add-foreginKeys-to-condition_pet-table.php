<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToConditionPetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('condition_pet', function (Blueprint $table) {
            $table->foreign('pet_id')->references('id')->on('pets')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('condition_id')->references('id')->on('conditions')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('condition_pet', function (Blueprint $table) {
            $table->dropForeign('condition_pet_pet_id_foreign');
            $table->dropForeign('condition_pet_condition_id_foreign');
        });
    }
}
