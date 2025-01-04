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
        Schema::create('application_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_code')->unique();
            $table->string('status_name')->unique();
            $table->integer('order')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['status_code', 'status_name']);
            $table->index(['status_code', 'status_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_statuses');
    }
};
