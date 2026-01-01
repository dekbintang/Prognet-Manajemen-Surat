<x-app-layout>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Agenda Kegiatan</h1>
            <div class="text-secondary">Kelola jadwal agenda kegiatan</div>
        </div>
        <a href="{{ route('agenda.create') }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i>Tambah Agenda
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-12 col-lg-8">
            <input class="form-control rounded-4 py-2" name="q" value="{{ request('q') }}" placeholder="Cari agenda...">
        </div>
        <div class="col-12 col-lg-4">
            <select name="status" class="form-select rounded-4 py-2">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
                <option value="selesai" @selected(request('status')==='selesai')>Selesai</option>
                <option value="batal" @selected(request('status')==='batal')>Batal</option>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-outline-secondary rounded-4 px-4 py-2" type="submit">
                <i class="bi bi-funnel me-2"></i>Terapkan
            </button>
            <a class="btn btn-link text-decoration-none" href="{{ route('agenda.index') }}">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-secondary small" style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3">Kegiatan</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($agendaKegiatans as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-semibold">{{ $item->nama_kegiatan }}</div>
                            <div class="text-secondary small">{{ $item->tempat ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="fw-semibold">
                                {{ $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai)->format('d/m/Y H:i') : '-' }}
                            </div>
                            <div class="text-secondary small">
                                s/d {{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('d/m/Y H:i') : '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $item->jenisAgenda->nama_jenis ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $st = $item->status;
                                $class = match($st) {
                                    'aktif' => 'bg-info-subtle border text-info-emphasis',
                                    'selesai' => 'bg-success-subtle border text-success-emphasis',
                                    'batal' => 'bg-danger-subtle border text-danger-emphasis',
                                    default => 'bg-light border'
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 {{ $class }}">{{ ucfirst($st) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a class="btn btn-light border rounded-4" href="{{ route('agenda.show', $item) }}"><i class="bi bi-eye"></i></a>
                                <a class="btn btn-light border rounded-4" href="{{ route('agenda.edit', $item) }}"><i class="bi bi-pencil-square"></i></a>
                                <form method="POST" action="{{ route('agenda.destroy', $item) }}" onsubmit="return confirm('Hapus agenda ini?')">
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
            {{ $agendaKegiatans->links() }}
        </div>
    </div>
</x-app-layout>
