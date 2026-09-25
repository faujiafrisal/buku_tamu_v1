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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
            $table->integer('usia')->default(20);
            $table->string('jumlah_rombongan')->default('1 orang');
            $table->string('bidang_tujuan')->nullable();
            $table->string('keperluan')->nullable();
            $table->string('no_whatsapp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
