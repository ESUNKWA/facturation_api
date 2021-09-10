<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_clients', function (Blueprint $table) {
            $table->increments('r_i');
            $table->integer('r_type_person');
            $table->string('r_nom', 35)->nullable();
            $table->string('r_prenoms')->nullable();
            $table->string('r_phone', 15)->unique();
            $table->string('r_email', 255)->unique();
            $table->text('r_description')->nullable();
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
        Schema::dropIfExists('t_clients');
    }
}
