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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_contract_signed')->default(false);
            $table->boolean('is_contract_sent')->default(false);
            $table->timestamp('contract_signed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_contract_signed');
            $table->dropColumn('is_contract_sent');
            $table->dropColumn('contract_signed_at');
        });
    }
};
