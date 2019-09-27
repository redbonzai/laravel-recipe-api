<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('recipes')) {
            Schema::create('recipes', static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id', false);
                $table->string('title');
                $table->text('description');
                $table->timestamps();
            });
            
            Schema::table('recipes', static function (Blueprint $table) {
               $table->foreign('user_id')->references('id')->on('users');
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
        Schema::disableForeignKeyConstraints();
        
        Schema::dropIfExists('recipes');
        
        Schema::enableForeignKeyConstraints();
    }
}
