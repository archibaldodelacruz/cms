<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTreatmentsLifeColumnInAnimalsHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animals_health', function (Blueprint $table) {
            $table->boolean('treatments_life')->default(0)->after('treatments_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animals_health', function (Blueprint $table) {
            $table->dropColumn('treatments_life');
        });
    }
}
