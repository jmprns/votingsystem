<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Partylist;

class CreatePartylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partylist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('party_name');
            $table->timestamps();
        });

        Partylist::create([
            "party_name" => 'Independent'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partylist');
    }
}
