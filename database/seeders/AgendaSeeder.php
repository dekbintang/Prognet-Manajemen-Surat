<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\AgendaKegiatan;
use App\Models\JenisAgenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = JenisAgenda::first();
        if (!$jenis) return;

        $creator = User::where('role', 'operator')->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        if (!$creator) return;

        $sm = SuratMasuk::first();
        $sk = SuratKeluar::first();

        for ($i = 1; $i <= 8; $i++) {
            $mulai = Carbon::now()->addDays($i)->setTime(9, 0);
            $selesai = (clone $mulai)->addHours(2);

            AgendaKegiatan::create([
                'nama_kegiatan' => "Agenda Kegiatan #$i",
                'jenis_agenda_id' => $jenis->id,
                'waktu_mulai' => $mulai,
                'waktu_selesai' => $selesai,
                'tempat' => 'Ruang Rapat ' . $i,
                'status' => 'aktif',
                'surat_masuk_id' => $i % 2 === 0 ? ($sm?->id) : null,
                'surat_keluar_id' => $i % 2 === 1 ? ($sk?->id) : null,
                'keterangan' => 'Keterangan agenda contoh #' . $i,
                'created_by' => $creator->id, // ✅ WAJIB
            ]);
        }
    }
}
