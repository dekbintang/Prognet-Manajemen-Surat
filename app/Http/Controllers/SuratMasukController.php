<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $kategoriId = $request->query('kategori_id');
        $status = $request->query('status_disposisi');

        $suratMasuks = SuratMasuk::with(['kategori', 'creator'])
            ->when($q, function ($qr) use ($q) {
                $qr->where('perihal', 'like', "%{$q}%")
                   ->orWhere('asal_surat', 'like', "%{$q}%")
                   ->orWhere('nomor_agenda', 'like', "%{$q}%");
            })
            ->when($kategoriId, fn($qr) => $qr->where('kategori_id', $kategoriId))
            ->when($status, fn($qr) => $qr->where('status_disposisi', $status))
            ->orderByDesc('tanggal_diterima')
            ->paginate(10)
            ->withQueryString();

        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat_masuk.index', compact('suratMasuks', 'kategoris', 'q', 'kategoriId', 'status'));
    }

    public function create()
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();
        return view('surat_masuk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_agenda'      => ['required', 'string', 'max:255', 'unique:surat_masuks,nomor_agenda'],
            'nomor_surat_asal'  => ['nullable', 'string', 'max:255'],
            'tanggal_surat'     => ['nullable', 'date'],
            'tanggal_diterima'  => ['nullable', 'date'],
            'asal_surat'        => ['required', 'string', 'max:255'],
            'perihal'           => ['required', 'string', 'max:255'],
            'kategori_id'       => ['required', 'exists:kategori_surats,id'],
            'isi_ringkas'       => ['nullable', 'string'],
            'status_disposisi'  => ['required', 'in:belum,proses,selesai'],
            'lampiran_file'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $data['created_by'] = auth()->id();

        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran/surat_masuk', 'public');
        }

        SuratMasuk::create($data);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['kategori', 'creator']);
        return view('surat_masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();
        return view('surat_masuk.edit', compact('suratMasuk', 'kategoris'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $data = $request->validate([
            'nomor_agenda'      => ['required', 'string', 'max:255', 'unique:surat_masuks,nomor_agenda,' . $suratMasuk->id],
            'nomor_surat_asal'  => ['nullable', 'string', 'max:255'],
            'tanggal_surat'     => ['nullable', 'date'],
            'tanggal_diterima'  => ['nullable', 'date'],
            'asal_surat'        => ['required', 'string', 'max:255'],
            'perihal'           => ['required', 'string', 'max:255'],
            'kategori_id'       => ['required', 'exists:kategori_surats,id'],
            'isi_ringkas'       => ['nullable', 'string'],
            'status_disposisi'  => ['required', 'in:belum,proses,selesai'],
            'lampiran_file'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('lampiran_file')) {
            if ($suratMasuk->lampiran_file) {
                Storage::disk('public')->delete($suratMasuk->lampiran_file);
            }
            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran/surat_masuk', 'public');
        }

        $suratMasuk->update($data);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->lampiran_file) {
            Storage::disk('public')->delete($suratMasuk->lampiran_file);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
