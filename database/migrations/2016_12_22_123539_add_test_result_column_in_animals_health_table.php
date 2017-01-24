<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestResultColumnInAnimalsHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animals_health', function (Blueprint $table) {
            $table->string('test_result')->nullable()->after('treatments_time');
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
            $table->dropColumn('test_result');
        });
    }
}
