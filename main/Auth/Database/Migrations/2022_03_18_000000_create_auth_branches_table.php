<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthBranchesTable extends Migration
{
    public function up()
    {
        Schema::create('auth_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained('auth_organizations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name', 255);
            $table->string('address', 255);            
            $table->foreignId('city_id')
                ->constrained('geo_cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
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
        Schema::dropIfExists('auth_branches');
    }
}
