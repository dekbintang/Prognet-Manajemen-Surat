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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat_asal')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->string('asal_surat');
            $table->string('perihal');
            $table->foreignId('kategori_id')->constrained('kategori_surats')->cascadeOnUpdate();
            $table->text('isi_ringkas')->nullable();
            $table->string('lampiran_file')->nullable();
            $table->string('status_disposisi')->default('belum'); // belum|proses|selesai
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
