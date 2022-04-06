<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthPermRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_perm_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->constrained('auth_roles')
                ->cascadeOnDelete();
            $table->foreignId('perm_id')
                ->constrained('auth_perms')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('auth_perm_role');
    }
}
