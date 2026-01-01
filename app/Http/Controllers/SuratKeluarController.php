<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $kategoriId = $request->query('kategori_id');
        $status = $request->query('status');

        $suratKeluars = SuratKeluar::with(['kategori', 'creator'])
            ->when($q, function ($qr) use ($q) {
                $qr->where('perihal', 'like', "%{$q}%")
                   ->orWhere('tujuan_surat', 'like', "%{$q}%")
                   ->orWhere('nomor_agenda', 'like', "%{$q}%")
                   ->orWhere('nomor_surat', 'like', "%{$q}%");
            })
            ->when($kategoriId, fn($qr) => $qr->where('kategori_id', $kategoriId))
            ->when($status, fn($qr) => $qr->where('status', $status))
            ->orderByDesc('tanggal_surat')
            ->paginate(10)
            ->withQueryString();

        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat_keluar.index', compact('suratKeluars', 'kategoris', 'q', 'kategoriId', 'status'));
    }

    public function create()
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();
        return view('surat_keluar.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_agenda'   => ['required', 'string', 'max:255', 'unique:surat_keluars,nomor_agenda'],
            'nomor_surat'    => ['nullable', 'string', 'max:255'],
            'tanggal_surat'  => ['nullable', 'date'],
            'tujuan_surat'   => ['required', 'string', 'max:255'],
            'perihal'        => ['required', 'string', 'max:255'],
            'status'         => ['required', 'in:draft,disetujui,dikirim'],
            'kategori_id'    => ['required', 'exists:kategori_surats,id'],
            'isi_ringkas'    => ['nullable', 'string'],
            'lampiran_file'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $data['created_by'] = auth()->id();

        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran/surat_keluar', 'public');
        }

        SuratKeluar::create($data);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['kategori', 'creator']);
        return view('surat_keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();
        return view('surat_keluar.edit', compact('suratKeluar', 'kategoris'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $data = $request->validate([
            'nomor_agenda'   => ['required', 'string', 'max:255', 'unique:surat_keluars,nomor_agenda,' . $suratKeluar->id],
            'nomor_surat'    => ['nullable', 'string', 'max:255'],
            'tanggal_surat'  => ['nullable', 'date'],
            'tujuan_surat'   => ['required', 'string', 'max:255'],
            'perihal'        => ['required', 'string', 'max:255'],
            'status'         => ['required', 'in:draft,disetujui,dikirim'],
            'kategori_id'    => ['required', 'exists:kategori_surats,id'],
            'isi_ringkas'    => ['nullable', 'string'],
            'lampiran_file'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('lampiran_file')) {
            if ($suratKeluar->lampiran_file) {
                Storage::disk('public')->delete($suratKeluar->lampiran_file);
            }
            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran/surat_keluar', 'public');
        }

        $suratKeluar->update($data);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->lampiran_file) {
            Storage::disk('public')->delete($suratKeluar->lampiran_file);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }
}
