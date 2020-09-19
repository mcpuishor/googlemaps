<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geocodes', static function (Blueprint $table) {
            $table->id();
            $table->string("place_id");
            $table->string("address_components");
            $table->string("viewport");
            $table->string("formatted_address");
            $table->string("accuracy");
            $table->string("lat");
            $table->string("lng");
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
        Schema::dropIfExists('queues');
    }
}
