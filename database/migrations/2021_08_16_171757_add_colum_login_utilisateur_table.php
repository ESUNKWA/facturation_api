<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumLoginUtilisateurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_gestion.utilisateurs', function (Blueprint $table) {

            $table->string('r_login', 20)->before('r_img')->unique();
            //$table->renameColumn('r_phone', 'r_tel')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_gestion.utilisateurs', function (Blueprint $table) {
            $table->dropColumn('r_login');
        });
    }
}
