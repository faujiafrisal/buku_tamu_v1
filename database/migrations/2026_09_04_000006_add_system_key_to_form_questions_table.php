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
        Schema::table('form_questions', function (Blueprint $table) {
            $table->string('system_key')->nullable()->after('id');
        });

        // Kosongkan dan masukkan data awal box 1 sampai 6
        DB::table('form_questions')->truncate();

        DB::table('form_questions')->insert([
            [
                'system_key' => 'identitas',
                'pertanyaan' => 'Identitas Pengunjung',
                'tipe_input' => 'radio',
                'opsi' => "Laki-Laki\nPerempuan",
                'wajib' => true,
                'urutan' => 1,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_key' => 'detail_kunjungan',
                'pertanyaan' => 'Detail Kunjungan',
                'tipe_input' => 'radio',
                'opsi' => "1 orang\n2 orang\n3 orang\n4 orang\n5-10 orang",
                'wajib' => true,
                'urutan' => 2,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_key' => 'layanan',
                'pertanyaan' => 'Layanan & Keperluan',
                'tipe_input' => 'select',
                'opsi' => "Konsultasi & Informasi Layanan\nPengurusan Dokumen / Perizinan Baru\nPerpanjangan / Pembaruan Berkas\nPengaduan / Keluhan Layanan\nPenyerahan / Pengambilan Berkas Fisik",
                'wajib' => true,
                'urutan' => 3,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_key' => null,
                'pertanyaan' => 'Instansi / Lembaga Asal Pengunjung',
                'tipe_input' => 'text',
                'opsi' => null,
                'wajib' => false,
                'urutan' => 4,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_key' => null,
                'pertanyaan' => 'Kritik, Saran, atau Catatan Pelayanan',
                'tipe_input' => 'textarea',
                'opsi' => null,
                'wajib' => false,
                'urutan' => 5,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_key' => 'kontak',
                'pertanyaan' => 'Kontak Pengunjung',
                'tipe_input' => 'text',
                'opsi' => null,
                'wajib' => true,
                'urutan' => 6,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_questions', function (Blueprint $table) {
            $table->dropColumn('system_key');
        });
    }
};