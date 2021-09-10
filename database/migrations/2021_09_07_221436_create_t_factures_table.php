<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_factures', function (Blueprint $table) {
            $table->increments('r_i');
            $table->string('r_num')->unique();
            $table->integer('r_client')->length(10)->unsigned();
            $table->integer('r_mnt');
            $table->timestamps();

            $table->foreign('r_client')->references('r_i')->on('t_clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_factures');
    }
}
