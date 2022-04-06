<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoplePersonsTable extends Migration
{
    public function up()
    {
        Schema::create('people_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('typedni', 6);
            $table->string('dni', 10);
            $table->string('cuit', 13)->nullable()->default(null);
            $table->string('birthday', 10)->nullable()->default(null);
            $table->string('address', 200)->nullable()->default(null);
            $table->foreignId('city_id')
                ->default(1)
                ->constrained('geo_cities')
                ->cascadeOnDelete();
            $table->enum('sex', ['SIN ESPECIFICAR', 'MUJER', 'HOMBRE', 'OTRO'])->default('SIN ESPECIFICAR')->nullable();
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
        Schema::dropIfExists('people_persons');
    }
}
