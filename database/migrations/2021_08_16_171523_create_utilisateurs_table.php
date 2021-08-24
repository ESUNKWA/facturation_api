<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_gestion.utilisateurs', function (Blueprint $table) {
            $table->increments('r_i');
            $table->string('r_nom');
            $table->string('r_prenoms');
            $table->string('r_email')->nulable()->unique();
            $table->string('r_phone');
            $table->boolean('r_status')->default(0);
            $table->text('r_description');
            $table->string('r_img')->default('default_img.png');
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
        Schema::dropIfExists('utilisateurs');
    }
}
