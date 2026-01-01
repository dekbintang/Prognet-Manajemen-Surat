<x-app-layout>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Surat Keluar</h1>
            <div class="text-secondary">Kelola semua surat keluar organisasi</div>
        </div>
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i>Tambah Surat Keluar
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-12 col-lg-8">
            <input class="form-control rounded-4 py-2" name="q" value="{{ request('q') }}" placeholder="Cari perihal/tujuan/nomor...">
        </div>
        <div class="col-12 col-lg-4">
            <select name="status" class="form-select rounded-4 py-2">
                <option value="">Semua Status</option>
                <option value="draft" @selected(request('status')==='draft')>Draft</option>
                <option value="disetujui" @selected(request('status')==='disetujui')>Disetujui</option>
                <option value="dikirim" @selected(request('status')==='dikirim')>Dikirim</option>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-outline-secondary rounded-4 px-4 py-2" type="submit">
                <i class="bi bi-funnel me-2"></i>Terapkan
            </button>
            <a class="btn btn-link text-decoration-none" href="{{ route('surat-keluar.index') }}">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-secondary small" style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3">Tujuan</th>
                        <th class="px-4 py-3">Perihal</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($suratKeluars as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-semibold">{{ $item->tujuan_surat }}</div>
                            <div class="text-secondary small">{{ $item->nomor_surat ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="fw-semibold">{{ $item->perihal }}</div>
                            <div class="text-secondary small">{{ $item->nomor_agenda }}</div>
                        </td>
                        <td class="px-4 py-3">
                            {{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('j/n/Y') : '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $st = $item->status;
                                $class = match($st) {
                                    'draft' => 'bg-light border text-secondary',
                                    'disetujui' => 'bg-info-subtle border text-info-emphasis',
                                    'dikirim' => 'bg-success-subtle border text-success-emphasis',
                                    default => 'bg-light border'
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 {{ $class }}">{{ ucfirst($st) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a class="btn btn-light border rounded-4" href="{{ route('surat-keluar.show', $item) }}"><i class="bi bi-eye"></i></a>
                                <a class="btn btn-light border rounded-4" href="{{ route('surat-keluar.edit', $item) }}"><i class="bi bi-pencil-square"></i></a>
                                <form method="POST" action="{{ route('surat-keluar.destroy', $item) }}" onsubmit="return confirm('Hapus surat keluar ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light border rounded-4" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-5">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body pt-3">
            {{ $suratKeluars->links() }}
        </div>
    </div>
</x-app-layout>
