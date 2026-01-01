<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;

class DisposisiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pimpinan = User::where('role', 'pimpinan')->first();

        $suratList = SuratMasuk::take(5)->get();

        foreach ($suratList as $sm) {
            Disposisi::create([
                'surat_masuk_id' => $sm->id,
                'dari_user_id' => $admin?->id,
                'kepada' => 'Pimpinan',
                'kepada_user_id' => $pimpinan?->id,
                'instruksi' => 'Mohon ditindaklanjuti dan buat arahan.',
                'batas_waktu' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'dikirim',
                'tanggal_disposisi' => now(),
                'tanggal_selesai' => null,
            ]);

            // status surat masuk jadi proses
            $sm->update(['status_disposisi' => 'proses']);
        }
    }
}
