<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthUsersTable extends Migration
{
    public function up()
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->nullable()
                ->default(0)
                ->constrained('people_persons')
                ->cascadeOnDelete();
            $table->foreignId('organization_id')
                ->nullable()
                ->default(config('fulljauscms.organization.id'))
                ->constrained('auth_organizations')
                ->cascadeOnDelete();
            $table->string('email')->nullable()->default(null);
            $table->string('email2')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('auth_sysusers');
    }
}
