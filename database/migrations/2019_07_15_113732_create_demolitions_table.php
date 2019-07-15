<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemolitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demolitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->string('phoneUser')->nullable();
            $table->string('comment')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->decimal('deposit_percentage')->nullable();
            $table->decimal('payment')->nullable();
            $table->decimal('deposit')->nullable();
            $table->timestamp('schedule')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')
                ->references('id')->on('status')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demolitions');
    }
}
