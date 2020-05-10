<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_user', function (Blueprint $table) {
            $table->integer('match_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('result',['A','B','E'])->default('E');
            $table->string('scoreboard_a')->default('0');
            $table->string('scoreboard_b')->default('0');
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
        Schema::dropIfExists('match_user');
    }
}
