<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',15);
            $table->string('nombre',20);
            $table->unsignedBigInteger('id_profesor');
            $table->unsignedBigInteger('id_aula');
            $table->timestamps();

            $table->foreign('id_aula')->references('id')->on('aulas');
            $table->foreign('id_profesor')->references('id')->on('profesors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
