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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('bdm_officer_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('country');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('agent_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('bdm_officer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unique('email');
            $table->unique('phone_number');
            $table->index(['first_name', 'last_name', 'middle_name']);
            $table->index(['created_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
