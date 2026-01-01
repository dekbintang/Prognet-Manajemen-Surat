<?php

namespace App\Http\Controllers;

use App\Models\JenisAgenda;
use Illuminate\Http\Request;

class JenisAgendaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $jenisAgendas = JenisAgenda::query()
            ->when($q, fn($qr) => $qr->where('nama_jenis', 'like', "%{$q}%"))
            ->orderBy('nama_jenis')
            ->paginate(10)
            ->withQueryString();

        return view('jenis_agenda.index', compact('jenisAgendas', 'q'));
    }

    public function create()
    {
        return view('jenis_agenda.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jenis' => ['required', 'string', 'max:255'],
            'deskripsi'  => ['nullable', 'string'],
        ]);

        JenisAgenda::create($data);

        return redirect()->route('jenis-agenda.index')->with('success', 'Jenis agenda berhasil ditambahkan.');
    }

    public function show(JenisAgenda $jenisAgenda)
    {
        return view('jenis_agenda.show', compact('jenisAgenda'));
    }

    public function edit(JenisAgenda $jenisAgenda)
    {
        return view('jenis_agenda.edit', compact('jenisAgenda'));
    }

    public function update(Request $request, JenisAgenda $jenisAgenda)
    {
        $data = $request->validate([
            'nama_jenis' => ['required', 'string', 'max:255'],
            'deskripsi'  => ['nullable', 'string'],
        ]);

        $jenisAgenda->update($data);

        return redirect()->route('jenis-agenda.index')->with('success', 'Jenis agenda berhasil diperbarui.');
    }

    public function destroy(JenisAgenda $jenisAgenda)
    {
        $jenisAgenda->delete();

        return redirect()->route('jenis-agenda.index')->with('success', 'Jenis agenda berhasil dihapus.');
    }
}
