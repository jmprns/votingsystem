<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('password');
            $table->string('alias');
            $table->string('fname');
            $table->string('lname');
            $table->string('mname')->nullable();
            $table->tinyInteger('isCandidate')->default('0');
            $table->tinyInteger('year_id');
            $table->tinyInteger('elc_id');
            $table->tinyInteger('cast');
            $table->string('number');
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
