<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ingredients')) {
            Schema::create('ingredients', static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('recipe_id');
                $table->string('name');
                $table->integer('quantity');
                $table->timestamps();
            });
            
            Schema::table('ingredients', static function($table) {
                $table->foreign('recipe_id')->references('id')->on('recipes');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
