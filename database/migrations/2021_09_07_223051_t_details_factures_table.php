<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TDetailsFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_details_factures', function (Blueprint $table) {
            $table->increments('r_i');
            $table->integer('r_facture')->length(10)->unsigned();
            $table->integer('r_produit')->unsigned()->length(10);
            $table->integer('r_quantite')->length(10);
            $table->integer('r_total');
            $table->text('r_description');
            $table->timestamps();
            $table->foreign('r_facture')->references('r_i')->on('t_factures');
            $table->foreign('r_produit')->references('r_i')->on('t_produit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_details_factures');
    }
}
