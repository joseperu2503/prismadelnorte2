<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno');
            $table->unsignedBigInteger('id_curso');
            $table->unsignedBigInteger('id_bimestre');
            $table->unsignedBigInteger('id_evaluacion');
            $table->integer('num_evaluacion');
            $table->integer('nota');
            $table->timestamps();

            $table->foreign('id_alumno')->references('id')->on('alumnos');
            $table->foreign('id_curso')->references('id')->on('cursos');
            $table->foreign('id_bimestre')->references('id')->on('bimestres');
            $table->foreign('id_evaluacion')->references('id')->on('evaluacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
