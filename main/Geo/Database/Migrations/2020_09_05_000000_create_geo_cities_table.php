<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('geo_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')
                ->nullable()
                ->default(0)
                ->constrained('geo_regions')
                ->cascadeOnDelete();
            $table->string('zonename', 200)->nullable();
            $table->string('name', 200);
            $table->decimal('latitude', 29, 12)->nullable()->default(0);
            $table->decimal('longitude', 29, 12)->nullable()->default(0);
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
        Schema::dropIfExists('geo_cities');
    }
}
