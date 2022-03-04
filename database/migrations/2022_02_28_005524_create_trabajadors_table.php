<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadors', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->string('primer_nombre',15);
            $table->string('segundo_nombre',15);
            $table->string('apellido_paterno',15);
            $table->string('apellido_materno',15);
            $table->integer('telefono');
            $table->string('direccion',100);
            $table->string('puesto',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajadors');
    }
}
