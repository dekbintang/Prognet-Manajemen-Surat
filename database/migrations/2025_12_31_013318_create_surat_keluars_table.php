<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->string('status')->default('draft');
            $table->foreignId('kategori_id')->constrained('kategori_surats')->cascadeOnUpdate();
            $table->text('isi_ringkas')->nullable();
            $table->string('lampiran_file')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
        {
            Schema::dropIfExists('surat_keluars');
        }
};
