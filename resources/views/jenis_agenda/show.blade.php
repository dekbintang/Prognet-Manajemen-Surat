<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Jenis Agenda</h1>
            <div class="text-secondary">{{ $jenisAgenda->nama_jenis }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jenis-agenda.edit', $jenisAgenda) }}" class="btn btn-primary rounded-4 px-4 py-2">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <a href="{{ route('jenis-agenda.index') }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="mb-2 text-secondary small">Nama Jenis</div>
            <div class="fw-semibold">{{ $jenisAgenda->nama_jenis }}</div>

            <hr class="my-4">

            <div class="mb-2 text-secondary small">Deskripsi</div>
            <div>{{ $jenisAgenda->deskripsi ?? '-' }}</div>
        </div>
    </div>
</x-app-layout>
