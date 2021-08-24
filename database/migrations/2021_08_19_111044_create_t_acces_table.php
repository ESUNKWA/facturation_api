<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAccesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_gestion.t_acces', function (Blueprint $table) {

            $table->increments('r_i');
            $table->integer('r_utilisateur');
            $table->string('r_mdp', 255);
            $table->dateTime('r_heure_cnx')->nullable();
            $table->dateTime('r_heure_dcnx')->nullable();
            $table->boolean('r_status')->default(0);
            $table->timestamps();

            $table->foreign('r_utilisateur')->references('r_i')->on('sc_gestion.utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_acces');
    }
}
