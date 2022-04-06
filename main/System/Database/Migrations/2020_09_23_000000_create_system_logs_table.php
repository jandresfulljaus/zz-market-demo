<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemLogsTable extends Migration
{
    public function up()
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->nullable()
                ->default(config('fulljaus.organization.id'))
                ->constrained('auth_organizations')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->default(0)
                ->constrained('auth_users')
                ->cascadeOnDelete();
            $table->string('slug', 255);
            $table->string('description', 255);
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
        Schema::dropIfExists('system_logs');
    }
}
