<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoRegionsTable extends Migration
{
    public function up()
    {
        Schema::create('geo_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                ->nullable()
                ->default(0)
                ->constrained('geo_countries')
                ->cascadeOnDelete();
            $table->string('name', 200);
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
        Schema::dropIfExists('geo_regions');
    }
}
