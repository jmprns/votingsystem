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
        Schema::create('year', function (Blueprint $table) {
            $table->increments('id');
            $table->string('year_name');
            $table->integer('dept_id');
            $table->timestamps();
        });

        Year::create(['year_name' => 'Grade 7', 'dept_id' => '1']);
        Year::create(['year_name' => 'Grade 8', 'dept_id' => '1']);
        Year::create(['year_name' => 'Grade 9', 'dept_id' => '1']);
        Year::create(['year_name' => 'Grade 10', 'dept_id' => '1']);

        Year::create(['year_name' => 'Grade 11', 'dept_id' => '2']);
        Year::create(['year_name' => 'Grade 12', 'dept_id' => '2']);

        Year::create(['year_name' => 'Grade 11', 'dept_id' => '3']);
        Year::create(['year_name' => 'Grade 12', 'dept_id' => '3']);

        Year::create(['year_name' => 'Grade 11', 'dept_id' => '4']);
        Year::create(['year_name' => 'Grade 12', 'dept_id' => '4']);

        Year::create(['year_name' => 'Grade 11', 'dept_id' => '5']);
        Year::create(['year_name' => 'Grade 12', 'dept_id' => '5']);

        Year::create(['year_name' => 'First Year', 'dept_id' => '6']);
        Year::create(['year_name' => 'Second Year', 'dept_id' => '6']);
        Year::create(['year_name' => 'Third Year', 'dept_id' => '6']);
        Year::create(['year_name' => 'Fourth Year', 'dept_id' => '6']);

        Year::create(['year_name' => 'First Year', 'dept_id' => '7']);
        Year::create(['year_name' => 'Second Year', 'dept_id' => '7']);
        Year::create(['year_name' => 'Third Year', 'dept_id' => '7']);
        Year::create(['year_name' => 'Fourth Year', 'dept_id' => '7']);

        Year::create(['year_name' => 'First Year', 'dept_id' => '8']);
        Year::create(['year_name' => 'Second Year', 'dept_id' => '8']);
        Year::create(['year_name' => 'Third Year', 'dept_id' => '8']);
        Year::create(['year_name' => 'Fourth Year', 'dept_id' => '8']);

        Year::create(['year_name' => 'First Year', 'dept_id' => '9']);
        Year::create(['year_name' => 'Second Year', 'dept_id' => '9']);
        Year::create(['year_name' => 'Third Year', 'dept_id' => '9']);
        Year::create(['year_name' => 'Fourth Year', 'dept_id' => '9']);

        Year::create(['year_name' => 'First Year', 'dept_id' => '10']);
        Year::create(['year_name' => 'Second Year', 'dept_id' => '10']);
        Year::create(['year_name' => 'Third Year', 'dept_id' => '10']);
        Year::create(['year_name' => 'Fourth Year', 'dept_id' => '10']);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year');
    }
}
