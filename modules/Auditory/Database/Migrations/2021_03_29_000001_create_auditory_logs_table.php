<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoryLogsTable extends Migration
{
    public function up()
    {
        Schema::create('auditory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('auth_users')
                ->nullOnDelete();
            $table->datetime('when')->nullable();
            $table->string('action', 255)->nullable();
            $table->text('description')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->text('device')->nullable();
            $table->text('request')->nullable();
            $table->string('method', 20)->nullable();
            $table->text('params')->nullable();
            $table->text('module')->nullable();
            $table->text('controller')->nullable();
            $table->text('model')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
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
        Schema::dropIfExists('auditory_logs');
    }
}
