<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('surat_masuk_id')
                ->constrained('surat_masuks')
                ->cascadeOnDelete();

            $table->foreignId('dari_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // tujuan disposisi (teks wajib), user tujuan (opsional)
            $table->string('kepada', 255);
            $table->foreignId('kepada_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('instruksi')->nullable();
            $table->date('batas_waktu')->nullable();

            // dikirim | dibaca | diproses | selesai
            $table->string('status', 20)->default('dikirim');

            $table->dateTime('tanggal_disposisi')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
