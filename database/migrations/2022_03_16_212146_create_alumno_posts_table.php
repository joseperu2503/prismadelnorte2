<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_post')->nullable();
            $table->unsignedBigInteger('id_aula')->nullable();
            $table->unsignedBigInteger('id_alumno')->nullable();        
            $table->timestamps();

            $table->foreign('id_post')->references('id')->on('posts');
            $table->foreign('id_aula')->references('id')->on('aulas');
            $table->foreign('id_alumno')->references('id')->on('alumnos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumno_posts');
    }
}
