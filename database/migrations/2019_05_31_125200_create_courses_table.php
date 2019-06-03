<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Course;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Course::create(['name' => 'JHS']);
        Course::create(['name' => 'ABM']);
        Course::create(['name' => 'GAS']);
        Course::create(['name' => 'HUMMS']);
        Course::create(['name' => 'STEM']);
        Course::create(['name' => 'BSA']);
        Course::create(['name' => 'BSBA']);
        Course::create(['name' => 'BSCS']);
        Course::create(['name' => 'BEED']);
        Course::create(['name' => 'CCJE']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
