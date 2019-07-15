<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->string('phone');
            $table->string('companyName');
            $table->string('companyAddress');
            $table->string('status')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();

            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();

            // Role
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
