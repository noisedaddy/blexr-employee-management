<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('ship_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('confirmation_token')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('ship_id')//id field on users tab;e
            ->references('id')//references id field on users table
            ->on('ships');//users table

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
