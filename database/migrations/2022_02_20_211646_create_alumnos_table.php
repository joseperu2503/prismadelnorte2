<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->string('primer_nombre',15);
            $table->string('segundo_nombre',15)->nullable();
            $table->string('apellido_paterno',15);
            $table->string('apellido_materno',15);
            $table->date('fecha_nacimiento')->format('d-m-Y');
            $table->string('departamento',20)->nullable();
            $table->string('provincia',50)->nullable();
            $table->string('distrito',50)->nullable();
            $table->string('religion',15)->nullable();
            $table->string('discapacidad',20)->nullable();
            $table->unsignedBigInteger('id_grado');
            $table->unsignedBigInteger('id_aula');
            $table->integer('telefono')->nullable();
            $table->string('email',100)->nullable();
            $table->string('direccion',400)->nullable();
            $table->string('foto_perfil',100);
            $table->unsignedBigInteger('id_genero');
            $table->string('password');   

            $table->string('nombre_padre',60)->nullable();
            $table->integer('dni_padre')->nullable();
            $table->integer('telefono_padre')->nullable();
            $table->string('nombre_madre',60)->nullable();
            $table->integer('dni_madre')->nullable();
            $table->integer('telefono_madre')->nullable();
            $table->string('nombre_apoderado',60)->nullable();
            $table->integer('dni_apoderado')->nullable();
            $table->integer('telefono_apoderado')->nullable();
            $table->timestamps();

            $table->foreign('id_aula')->references('id')->on('aulas');
            $table->foreign('id_grado')->references('id')->on('grados');
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
        Schema::dropIfExists('alumnos');
    }
}
