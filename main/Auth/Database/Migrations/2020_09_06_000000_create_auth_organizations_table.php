<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthOrganizationsTable extends Migration
{
    public function up()
    {
        Schema::create('auth_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('city_id')
                ->nullable()
                ->default(1531)
                ->constrained('geo_cities')
                ->cascadeOnDelete();
            $table->bigInteger('position')->nullable()->default(0);
            $table->string('url', 250);
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
        Schema::dropIfExists('auth_perms');
    }
}
