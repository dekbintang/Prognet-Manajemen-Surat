<x-app-layout>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Kategori Surat</h1>
            <div class="text-secondary">Kelola master kategori surat</div>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-12 col-lg-6">
            <input class="form-control rounded-4 py-2" name="q" value="{{ request('q') }}" placeholder="Cari kategori...">
        </div>
        <div class="col-12 col-lg-2">
            <button class="btn btn-outline-secondary rounded-4 w-100 py-2" type="submit">
                <i class="bi bi-search me-2"></i>Cari
            </button>
        </div>
        <div class="col-12 col-lg-2">
            <a class="btn btn-link text-decoration-none w-100 py-2" href="{{ route('kategori.index') }}">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-secondary small" style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($kategori as $item)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">{{ $item->nama_kategori }}</td>
                        <td class="px-4 py-3 text-secondary">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a class="btn btn-light border rounded-4" href="{{ route('kategori.show', $item) }}" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn btn-light border rounded-4" href="{{ route('kategori.edit', $item) }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('kategori.destroy', $item) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light border rounded-4" type="submit" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
            {{ $kategori->links() }}
        </div>
    </div>
</x-app-layout>
