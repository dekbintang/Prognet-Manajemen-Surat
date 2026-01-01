<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Agenda</h1>
            <div class="text-secondary">{{ $agendaKegiatan->nama_kegiatan }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('agenda.edit', $agendaKegiatan) }}" class="btn btn-primary rounded-4 px-4 py-2">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <a href="{{ route('agenda.index') }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Jenis</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->jenisAgenda->nama_jenis ?? '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Tempat</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->tempat ?? '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Waktu Mulai</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->waktu_mulai ? \Carbon\Carbon::parse($agendaKegiatan->waktu_mulai)->format('d/m/Y H:i') : '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Waktu Selesai</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->waktu_selesai ? \Carbon\Carbon::parse($agendaKegiatan->waktu_selesai)->format('d/m/Y H:i') : '-' }}</div>
                </div>
                <div class="col-12">
                    <div class="text-secondary small">Keterangan</div>
                    <div class="mt-1">{{ $agendaKegiatan->keterangan ?? '-' }}</div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Surat Masuk</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->suratMasuk->nomor_agenda ?? '-' }}</div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="text-secondary small">Surat Keluar</div>
                    <div class="fw-semibold">{{ $agendaKegiatan->suratKeluar->nomor_agenda ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
