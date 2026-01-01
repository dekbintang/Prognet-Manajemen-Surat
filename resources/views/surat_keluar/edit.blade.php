<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit Surat Keluar</h1>
            <div class="text-secondary">Perbarui data surat keluar</div>
        </div>
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <form method="POST" action="{{ route('surat-keluar.update', $suratKeluar) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('surat_keluar._form', ['suratKeluar' => $suratKeluar, 'kategoris' => $kategoris])
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary rounded-4 px-4 py-2 fw-semibold" type="submit"><i class="bi bi-save me-2"></i>Simpan</button>
                    <a class="btn btn-light border rounded-4 px-4 py-2" href="{{ route('surat-keluar.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
