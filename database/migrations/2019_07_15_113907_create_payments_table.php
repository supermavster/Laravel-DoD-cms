<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('mean_payment');
            $table->string('sale_id');
            $table->string('total');
            $table->timestamp('started_at');
            $table->timestamp('end_at');
            $table->string('status');
            $table->decimal('refund_price')->nullable();

            $table->integer('demolition_id')->unsigned();
            $table->foreign('demolition_id')
                ->references('id')->on('demolitions')
                ->onDelete('cascade');

            $table->integer('typePayment_id')->unsigned();
            $table->foreign('typePayment_id')
                ->references('id')->on('typePayments')
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
        Schema::dropIfExists('payments');
    }
}
