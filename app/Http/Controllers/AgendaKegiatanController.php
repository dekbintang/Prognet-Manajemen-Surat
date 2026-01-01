<?php

namespace App\Http\Controllers;

use App\Models\AgendaKegiatan;
use App\Models\JenisAgenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $jenisId = $request->query('jenis_agenda_id');
        $status = $request->query('status');

        $agendaKegiatans = AgendaKegiatan::with(['jenisAgenda', 'creator', 'suratMasuk', 'suratKeluar'])
            ->when($q, fn($qr) => $qr->where('nama_kegiatan', 'like', "%{$q}%"))
            ->when($jenisId, fn($qr) => $qr->where('jenis_agenda_id', $jenisId))
            ->when($status, fn($qr) => $qr->where('status', $status))
            ->orderByDesc('waktu_mulai')
            ->paginate(10)
            ->withQueryString();

        $jenisAgendas = JenisAgenda::orderBy('nama_jenis')->get();

        return view('agenda.index', compact('agendaKegiatans', 'jenisAgendas', 'q', 'jenisId', 'status'));
    }

    public function create()
    {
        $jenisAgendas = JenisAgenda::orderBy('nama_jenis')->get();
        $suratMasuks  = SuratMasuk::select('id', 'nomor_agenda', 'perihal')->orderByDesc('id')->limit(200)->get();
        $suratKeluars = SuratKeluar::select('id', 'nomor_agenda', 'perihal')->orderByDesc('id')->limit(200)->get();

        return view('agenda.create', compact('jenisAgendas', 'suratMasuks', 'suratKeluars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan'   => ['required', 'string', 'max:255'],
            'jenis_agenda_id' => ['required', 'exists:jenis_agendas,id'],
            'waktu_mulai'     => ['required', 'date'],
            'waktu_selesai'   => ['nullable', 'date', 'after_or_equal:waktu_mulai'],
            'tempat'          => ['nullable', 'string', 'max:255'],
            'keterangan'      => ['nullable', 'string'],
            'status'          => ['required', 'in:aktif,selesai,batal'],

            'surat_masuk_id'  => ['nullable', 'exists:surat_masuks,id'],
            'surat_keluar_id' => ['nullable', 'exists:surat_keluars,id'],
        ]);

        // Optional: minimal rule biar tidak dua-duanya terisi
        if (!empty($data['surat_masuk_id']) && !empty($data['surat_keluar_id'])) {
            return back()->withErrors(['surat_masuk_id' => 'Pilih salah satu: surat masuk atau surat keluar.'])->withInput();
        }

        $data['created_by'] = auth()->id();

        AgendaKegiatan::create($data);

        return redirect()->route('agenda.index')->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function show(AgendaKegiatan $agendaKegiatan)
    {
        $agendaKegiatan->load(['jenisAgenda', 'creator', 'suratMasuk', 'suratKeluar']);
        return view('agenda.show', compact('agendaKegiatan'));
    }

    public function edit(AgendaKegiatan $agendaKegiatan)
    {
        $jenisAgendas = JenisAgenda::orderBy('nama_jenis')->get();
        $suratMasuks  = SuratMasuk::select('id', 'nomor_agenda', 'perihal')->orderByDesc('id')->limit(200)->get();
        $suratKeluars = SuratKeluar::select('id', 'nomor_agenda', 'perihal')->orderByDesc('id')->limit(200)->get();

        return view('agenda.edit', compact('agendaKegiatan', 'jenisAgendas', 'suratMasuks', 'suratKeluars'));
    }

    public function update(Request $request, AgendaKegiatan $agendaKegiatan)
    {
        $data = $request->validate([
            'nama_kegiatan'   => ['required', 'string', 'max:255'],
            'jenis_agenda_id' => ['required', 'exists:jenis_agendas,id'],
            'waktu_mulai'     => ['required', 'date'],
            'waktu_selesai'   => ['nullable', 'date', 'after_or_equal:waktu_mulai'],
            'tempat'          => ['nullable', 'string', 'max:255'],
            'keterangan'      => ['nullable', 'string'],
            'status'          => ['required', 'in:aktif,selesai,batal'],

            'surat_masuk_id'  => ['nullable', 'exists:surat_masuks,id'],
            'surat_keluar_id' => ['nullable', 'exists:surat_keluars,id'],
        ]);

        if (!empty($data['surat_masuk_id']) && !empty($data['surat_keluar_id'])) {
            return back()->withErrors(['surat_masuk_id' => 'Pilih salah satu: surat masuk atau surat keluar.'])->withInput();
        }

        $agendaKegiatan->update($data);

        return redirect()->route('agenda.index')->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroy(AgendaKegiatan $agendaKegiatan)
    {
        $agendaKegiatan->delete();

        return redirect()->route('agenda.index')->with('success', 'Agenda kegiatan berhasil dihapus.');
    }
}
