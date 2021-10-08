<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Department;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dept_name');
            $table->timestamps();
        });

        Department::create(['dept_name' => 'JHS']);
        Department::create(['dept_name' => 'ABM']);
        Department::create(['dept_name' => 'GAS']);
        Department::create(['dept_name' => 'HUMMS']);
        Department::create(['dept_name' => 'STEM']);
        Department::create(['dept_name' => 'BSA']);
        Department::create(['dept_name' => 'BSBA']);
        Department::create(['dept_name' => 'BSCS']);
        Department::create(['dept_name' => 'BEED']);
        Department::create(['dept_name' => 'CCJE']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department');
    }
}
