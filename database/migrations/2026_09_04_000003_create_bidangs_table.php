<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bidang')->unique();
            $table->timestamps();
        });

        // Insert default options
        $defaultBidangs = [
            'DPMPTSP (Perizinan & Penanaman Modal)',
            'Disdukcapil (Kependudukan & Catatan Sipil)',
            'Bapenda (Pajak & Retribusi Daerah)',
            'SAMSAT (Pajak Kendaraan & STNK)',
            'BPJS Kesehatan & Ketenagakerjaan',
            'Dinas Perhubungan (Dishub)',
            'Sekretariat / Layanan Umum',
            'Lainnya'
        ];

        foreach ($defaultBidangs as $bidang) {
            DB::table('bidangs')->insert([
                'nama_bidang' => $bidang,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
