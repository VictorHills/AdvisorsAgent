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
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('bdm_officer_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('country');
            $table->string('class_of_degree');
            $table->text('additional_notes')->nullable();
            $table->string('signature')->nullable();
            $table->json('schools_of_choice');
            $table->json('country_of_preference');
            $table->json('application_documents')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
