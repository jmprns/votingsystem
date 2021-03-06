<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Year;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('course_id');
            $table->timestamps();
        });

        Year::create(['name' => 'Grade 7', 'course_id' => '1']);
        Year::create(['name' => 'Grade 8', 'course_id' => '1']);
        Year::create(['name' => 'Grade 9', 'course_id' => '1']);
        Year::create(['name' => 'Grade 10', 'course_id' => '1']);

        Year::create(['name' => 'Grade 11', 'course_id' => '2']);
        Year::create(['name' => 'Grade 12', 'course_id' => '2']);

        Year::create(['name' => 'Grade 11', 'course_id' => '3']);
        Year::create(['name' => 'Grade 12', 'course_id' => '3']);

        Year::create(['name' => 'Grade 11', 'course_id' => '4']);
        Year::create(['name' => 'Grade 12', 'course_id' => '4']);

        Year::create(['name' => 'Grade 11', 'course_id' => '5']);
        Year::create(['name' => 'Grade 12', 'course_id' => '5']);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('years');
    }
}
