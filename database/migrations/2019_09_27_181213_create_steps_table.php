<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('steps')) {
           Schema::create('steps', static function (Blueprint $table) {
               $table->bigIncrements('id');
               $table->unsignedBigInteger('recipe_id');
               $table->integer('step_order');
               $table->string('description');
               $table->timestamps();
           });
    
           Schema::table('steps', static function($table) {
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
        Schema::dropIfExists('steps');
    }
}
