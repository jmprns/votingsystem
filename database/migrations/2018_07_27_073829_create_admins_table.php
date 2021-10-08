<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Admin;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('fname');
            $table->string('lname');
            $table->string('mname')->nullable();
            $table->string('position');
            $table->tinyInteger('lvl')->default(1);
            $table->string('image');
            $table->rememberToken();
            $table->timestamps();
        });

        Admin::create([
            "username" => "root",
            "password" => Hash::make('root'),
            "fname" => 'Juan',
            "lname" => 'Dela Cruz',
            "mname" => 'A',
            "position" => 'School Admin',
            "lvl" => 0,
            "image" => '00.png'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
