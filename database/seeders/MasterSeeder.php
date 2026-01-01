<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriSurat;
use App\Models\JenisAgenda;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Surat
        $kategoriData = [
            ['nama_kategori' => 'Undangan', 'deskripsi' => 'Surat undangan kegiatan'],
            ['nama_kategori' => 'Pemberitahuan', 'deskripsi' => 'Surat pemberitahuan resmi'],
            ['nama_kategori' => 'Permohonan', 'deskripsi' => 'Surat permohonan'],
            ['nama_kategori' => 'Lainnya', 'deskripsi' => null],
        ];

        foreach ($kategoriData as $k) {
            KategoriSurat::updateOrCreate(
                ['nama_kategori' => $k['nama_kategori']],
                ['deskripsi' => $k['deskripsi']]
            );
        }

        // Jenis Agenda
        $jenisAgendaData = [
            ['nama_jenis' => 'Rapat', 'deskripsi' => 'Agenda rapat internal/eksternal'],
            ['nama_jenis' => 'Kunjungan', 'deskripsi' => 'Agenda kunjungan dinas'],
            ['nama_jenis' => 'Acara', 'deskripsi' => 'Agenda acara resmi'],
        ];

        foreach ($jenisAgendaData as $j) {
            JenisAgenda::updateOrCreate(
                ['nama_jenis' => $j['nama_jenis']],
                ['deskripsi' => $j['deskripsi']]
            );
        }
    }
}
