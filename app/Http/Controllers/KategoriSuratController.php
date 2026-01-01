<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $kategori = KategoriSurat::query()
            ->when($q, fn($qr) => $qr->where('nama_kategori', 'like', "%{$q}%"))
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategori', 'q'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi'     => ['nullable', 'string'],
        ]);

        KategoriSurat::create($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(KategoriSurat $kategoriSurat)
    {
        return view('kategori.show', compact('kategoriSurat'));
    }

    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('kategori.edit', compact('kategoriSurat'));
    }

    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi'     => ['nullable', 'string'],
        ]);

        $kategoriSurat->update($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriSurat $kategoriSurat)
    {
        $kategoriSurat->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
