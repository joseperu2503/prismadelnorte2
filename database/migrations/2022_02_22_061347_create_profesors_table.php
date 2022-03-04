<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesors', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->string('primer_nombre',15);
            $table->string('segundo_nombre',15);
            $table->string('apellido_paterno',15);
            $table->string('apellido_materno',15);
            $table->integer('telefono');
            $table->string('email',100);
            $table->string('direccion',100);
            $table->unsignedBigInteger('id_genero');
            $table->string('password');
            $table->string('foto_perfil',100);
            $table->timestamps();

            $table->foreign('id_genero')->references('id')->on('generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesors');
    }
}
