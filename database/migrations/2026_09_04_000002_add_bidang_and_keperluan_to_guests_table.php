<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('bidang_tujuan')->nullable()->after('jumlah_rombongan');
            $table->string('keperluan')->nullable()->after('bidang_tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['bidang_tujuan', 'keperluan']);
        });
    }
};
