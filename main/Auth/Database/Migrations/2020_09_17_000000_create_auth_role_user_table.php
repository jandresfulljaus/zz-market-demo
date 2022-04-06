<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->constrained('auth_roles')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('auth_users')
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
        Schema::dropIfExists('auth_role_user');
    }
}
