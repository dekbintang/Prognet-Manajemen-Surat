<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index(SuratMasuk $suratMasuk)
    {
        $disposisis = $suratMasuk->disposisis()
            ->with(['dariUser', 'kepadaUser'])
            ->latest()
            ->paginate(10);

        return view('disposisi.index', compact('suratMasuk', 'disposisis'));
    }

    public function create(SuratMasuk $suratMasuk)
    {
        $users = User::orderBy('name')->get();

        return view('disposisi.create', compact('suratMasuk', 'users'));
    }

    public function store(Request $request, SuratMasuk $suratMasuk)
    {
        $data = $request->validate([
            'kepada' => ['required', 'string', 'max:255'],
            'kepada_user_id' => ['nullable', 'exists:users,id'],
            'instruksi' => ['nullable', 'string'],
            'batas_waktu' => ['nullable', 'date'],
        ]);

        $data['surat_masuk_id'] = $suratMasuk->id;
        $data['dari_user_id'] = auth()->id();
        $data['status'] = 'dikirim';
        $data['tanggal_disposisi'] = now();

        Disposisi::create($data);

        // update status surat masuk
        if ($suratMasuk->status_disposisi === 'belum') {
            $suratMasuk->update(['status_disposisi' => 'proses']);
        }

        return redirect()
            ->route('surat-masuk.disposisi.index', $suratMasuk)
            ->with('success', 'Disposisi berhasil dibuat.');
    }

    public function update(Request $request, SuratMasuk $suratMasuk, Disposisi $disposisi)
    {
        // pastikan disposisi milik surat ini
        abort_unless($disposisi->surat_masuk_id === $suratMasuk->id, 404);

        $data = $request->validate([
            'status' => ['required', 'in:dikirim,dibaca,diproses,selesai'],
        ]);

        if ($data['status'] === 'selesai' && empty($disposisi->tanggal_selesai)) {
            $data['tanggal_selesai'] = now();
        }

        $disposisi->update($data);

        // update status surat masuk berdasarkan semua disposisi
        $masihAdaYangBelumSelesai = $suratMasuk->disposisis()
            ->where('status', '!=', 'selesai')
            ->exists();

        if ($suratMasuk->disposisis()->count() === 0) {
            $suratMasuk->update(['status_disposisi' => 'belum']);
        } elseif ($masihAdaYangBelumSelesai) {
            $suratMasuk->update(['status_disposisi' => 'proses']);
        } else {
            $suratMasuk->update(['status_disposisi' => 'selesai']);
        }

        return back()->with('success', 'Status disposisi diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk, Disposisi $disposisi)
    {
        abort_unless($disposisi->surat_masuk_id === $suratMasuk->id, 404);

        $disposisi->delete();

        // recalculasi status surat masuk
        $count = $suratMasuk->disposisis()->count();
        if ($count === 0) {
            $suratMasuk->update(['status_disposisi' => 'belum']);
        }

        return back()->with('success', 'Disposisi dihapus.');
    }
}
