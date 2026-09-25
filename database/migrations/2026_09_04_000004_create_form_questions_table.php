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
        Schema::create('form_questions', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->enum('tipe_input', ['text', 'textarea', 'select', 'number', 'radio'])->default('text');
            $table->text('opsi')->nullable();
            $table->boolean('wajib')->default(true);
            $table->integer('urutan')->default(1);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });

        // Data awal pertanyaan kustom contoh
        DB::table('form_questions')->insert([
            [
                'pertanyaan' => 'Instansi / Lembaga Asal Pengunjung',
                'tipe_input' => 'text',
                'opsi' => null,
                'wajib' => false,
                'urutan' => 1,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Kritik, Saran, atau Catatan Pelayanan',
                'tipe_input' => 'textarea',
                'opsi' => null,
                'wajib' => false,
                'urutan' => 2,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_questions');
    }
};
