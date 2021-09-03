<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_produit', function (Blueprint $table) {
            $table->increments('r_i');
            $table->integer('r_categorie')->length(10)->unsigned();
            $table->string('r_libelle');
            $table->integer('r_stock')->length(1)->default(0);
            $table->text('r_description')->nullable();
            $table->integer('r_status')->length(1)->default(1);
            $table->timestamps();
            $table->foreign('r_categorie')->references('r_i')->on('t_categorie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_produit');
    }
}
