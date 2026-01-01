<?php

namespace App\Http\Controllers;

use App\Models\AgendaKegiatan;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $countSuratMasuk  = SuratMasuk::count();
        $countSuratKeluar = SuratKeluar::count();
        $countAgenda      = AgendaKegiatan::count();

        // Statistik status disposisi surat masuk (sesuaikan jika value status kamu berbeda)
        $statusBelum  = SuratMasuk::where('status_disposisi', 'belum')->count();
        $statusProses = SuratMasuk::where('status_disposisi', 'proses')->count();
        $statusSelesai = SuratMasuk::where('status_disposisi', 'selesai')->count();

        // Data terbaru
        $latestSuratMasuk = SuratMasuk::latest()->take(5)->get();
        $latestSuratKeluar = SuratKeluar::latest()->take(5)->get();

        // Agenda terdekat (kalau ada waktu_mulai)
        $upcomingAgenda = AgendaKegiatan::orderBy('waktu_mulai', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'countSuratMasuk',
            'countSuratKeluar',
            'countAgenda',
            'statusBelum',
            'statusProses',
            'statusSelesai',
            'latestSuratMasuk',
            'latestSuratKeluar',
            'upcomingAgenda'
        ));
    }
}
