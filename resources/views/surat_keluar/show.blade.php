<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Surat Keluar</h1>
            <div class="text-secondary">{{ $suratKeluar->perihal }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('surat-keluar.edit', $suratKeluar) }}" class="btn btn-primary rounded-4 px-4 py-2">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Nomor Agenda</div>
                    <div class="fw-semibold">{{ $suratKeluar->nomor_agenda }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Nomor Surat</div>
                    <div class="fw-semibold">{{ $suratKeluar->nomor_surat ?? '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Tanggal</div>
                    <div class="fw-semibold">{{ $suratKeluar->tanggal_surat ? \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('j/n/Y') : '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Status</div>
                    <div class="fw-semibold">{{ ucfirst($suratKeluar->status) }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Tujuan</div>
                    <div class="fw-semibold">{{ $suratKeluar->tujuan_surat }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Kategori</div>
                    <div class="fw-semibold">{{ $suratKeluar->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div class="col-12">
                    <div class="text-secondary small">Isi Ringkas</div>
                    <div class="mt-1">{{ $suratKeluar->isi_ringkas ?? '-' }}</div>
                </div>
                <div class="col-12">
                    <div class="text-secondary small">Lampiran</div>
                    @if($suratKeluar->lampiran_file)
                        <a href="{{ asset('storage/'.$suratKeluar->lampiran_file) }}" target="_blank" class="fw-semibold">
                            <i class="bi bi-paperclip me-1"></i> Lihat Lampiran
                        </a>
                    @else
                        <div class="fw-semibold">-</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
