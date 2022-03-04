<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('titulo',100)->nullable();
            $table->string('imagen',100)->nullable();
            $table->text('iframe',100)->nullable();
            $table->text('descripcion',1000)->nullable();
            $table->unsignedBigInteger('id_curso')->nullable();           
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_curso')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
