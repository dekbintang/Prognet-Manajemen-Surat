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
        Schema::create('agenda_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->foreignId('jenis_agenda_id')->constrained('jenis_agendas')->cascadeOnUpdate();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable();
            $table->string('tempat')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('aktif'); // aktif|selesai|batal

            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuks')->nullOnDelete();
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluars')->nullOnDelete();

            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_kegiatans');
    }
};
