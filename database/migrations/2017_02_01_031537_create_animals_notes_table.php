<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned();
            $table->dateTime('published_at');
            $table->string('status');
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });

        Schema::create('animals_notes_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('note_id')->unsigned();
            $table->string('locale')->index();
            $table->text('title');
            $table->text('text');
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->unique(['note_id', 'locale']);
            $table->foreign('note_id')->references('id')->on('animals_notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals_notes_translations');
        Schema::dropIfExists('animals_notes');
    }
}
