<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlToCocktailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            $table->string('image_url')
                  ->nullable()       // Permite valores NULL
                  ->after('instructions');  // Posiciona la columna después de 'instructions'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            $table->dropColumn('image_url');  // Elimina la columna si se revierte la migración
        });
    }
}