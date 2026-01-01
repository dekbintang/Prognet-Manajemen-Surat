<x-app-layout>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Jenis Agenda</h1>
            <div class="text-secondary">Kelola master jenis agenda</div>
        </div>
        <a href="{{ route('jenis-agenda.create') }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i>Tambah Jenis
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-12 col-lg-6">
            <input class="form-control rounded-4 py-2" name="q" value="{{ request('q') }}" placeholder="Cari jenis agenda...">
        </div>
        <div class="col-12 col-lg-2">
            <button class="btn btn-outline-secondary rounded-4 w-100 py-2" type="submit">
                <i class="bi bi-search me-2"></i>Cari
            </button>
        </div>
        <div class="col-12 col-lg-2">
            <a class="btn btn-link text-decoration-none w-100 py-2" href="{{ route('jenis-agenda.index') }}">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-secondary small" style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3">Nama Jenis</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jenisAgendas as $item)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">{{ $item->nama_jenis }}</td>
                        <td class="px-4 py-3 text-secondary">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a class="btn btn-light border rounded-4" href="{{ route('jenis-agenda.show', $item) }}"><i class="bi bi-eye"></i></a>
                                <a class="btn btn-light border rounded-4" href="{{ route('jenis-agenda.edit', $item) }}"><i class="bi bi-pencil-square"></i></a>
                                <form method="POST" action="{{ route('jenis-agenda.destroy', $item) }}" onsubmit="return confirm('Hapus jenis agenda ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light border rounded-4" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-secondary py-5">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body pt-3">
            {{ $jenisAgendas->links() }}
        </div>
    </div>
</x-app-layout>
