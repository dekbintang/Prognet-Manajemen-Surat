<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\KategoriSurat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class SuratSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = KategoriSurat::first();
        if (!$kategori) return;

        // ambil user untuk created_by (pakai operator kalau ada)
        $creator = User::where('role', 'operator')->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        if (!$creator) return;

        // Surat Masuk
        for ($i = 1; $i <= 10; $i++) {
            SuratMasuk::create([
                'nomor_agenda' => 'SM-' . str_pad((string)$i, 3, '0', STR_PAD_LEFT) . '/2025',
                'nomor_surat_asal' => '00' . $i . '/EXT/XII/2025',
                'tanggal_surat' => Carbon::now()->subDays(rand(5, 30))->toDateString(),
                'tanggal_diterima' => Carbon::now()->subDays(rand(1, 10))->toDateString(),
                'asal_surat' => 'Instansi ' . $i,
                'kategori_id' => $kategori->id,
                'perihal' => 'Permohonan Informasi #' . $i,
                'status_disposisi' => 'belum',
                'isi_ringkas' => 'Ringkasan surat masuk contoh #' . $i,
                'lampiran_file' => null,
                'created_by' => $creator->id, // ✅ WAJIB
            ]);
        }

        // Surat Keluar (kalau tabel surat_keluars juga punya created_by, isi juga)
        for ($i = 1; $i <= 10; $i++) {
            SuratKeluar::create([
                'nomor_agenda' => 'SK-' . str_pad((string)$i, 3, '0', STR_PAD_LEFT) . '/2025',
                'nomor_surat' => '00' . $i . '/ORG/SK/XII/2025',
                'tanggal_surat' => Carbon::now()->subDays(rand(1, 20))->toDateString(),
                'tujuan_surat' => 'Tujuan ' . $i,
                'kategori_id' => $kategori->id,
                'perihal' => 'Balasan Surat #' . $i,
                'status' => 'draft',
                'isi_ringkas' => 'Ringkasan surat keluar contoh #' . $i,
                'lampiran_file' => null,
                'created_by' => $creator->id, // ✅ kalau kolomnya ada
            ]);
        }
    }
}
