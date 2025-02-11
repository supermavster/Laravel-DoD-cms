<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer');

            $table->integer('question_id')->unsigned()->default(3);
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');

            $table->integer('demolition_id')->unsigned();
            $table->foreign('demolition_id')
                ->references('id')->on('demolitions')
                ->onDelete('cascade');

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
        Schema::dropIfExists('answers');
    }
}
