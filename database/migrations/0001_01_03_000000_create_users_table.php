<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bdm_officer_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('agency_name')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('email')->unique();
            $table->string('role_name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_terms_and_condition_accepted')->default(false);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bdm_officer_id')
                ->references('id')
                ->on('business_development_officers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
};
