<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocktailsTable extends Migration
{
    public function up()
    {
        Schema::create('cocktails', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->enum('tipo', ['alcoholico', 'no alcoholico']);
            $table->text('instructions');
            $table->timestamp('create_at')->nullable(); // ← Sin la "d"
            $table->timestamp('update_at')->nullable(); // ← Sin la "d"
        });
    }

    public function down()
    {
        Schema::dropIfExists('cocktails');
    }
}