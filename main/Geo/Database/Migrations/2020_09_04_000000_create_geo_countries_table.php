<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('geo_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('iso', 4);
            $table->string('phone', 4);
            $table->bigInteger('position')->nullable()->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_countries');
    }
}
