<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_utilisateurs', function (Blueprint $table) {
            $table->increments('r_i');
            $table->string('r_nom');
            $table->increments('r_prenoms');
            $table->increments('r_phone');
            $table->increments('r_description');
            $table->increments('r_login');
            $table->increments('r_i');
            $table->increments('r_i');
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
        Schema::dropIfExists('t_utilisateurs');
    }
}
