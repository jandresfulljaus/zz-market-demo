<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('form_data_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->default(config('fulljaus.organization.id'))
                ->constrained('auth_organizations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('user_id')
                ->constrained('auth_users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('auth_users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->json('personal_data');
            $table->json('family_unit');
            $table->json('housing');
            $table->json('health');
            $table->json('contact');
            $table->text('suggestions')->nullable();
            $table->timestamp('processed_at')->nullable();
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
        Schema::dropIfExists('form_data_updates');
    }
}
