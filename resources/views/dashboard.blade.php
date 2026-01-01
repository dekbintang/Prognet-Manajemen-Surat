<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard</h1>
            <div class="text-secondary">Ringkasan sistem manajemen surat</div>
        </div>

        <div class="d-flex gap-2">
            @if(auth()->user()?->role !== 'user')
                <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary rounded-4 px-4">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Surat Masuk
                </a>
            @endif
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Surat Masuk</div>
                            <div class="fs-2 fw-bold">{{ number_format($countSuratMasuk) }}</div>
                        </div>
                        <div class="rounded-4 p-3" style="background:#eaf7ef;">
                            <i class="bi bi-inbox fs-3 text-success"></i>
                        </div>
                    </div>

                    @php
                        $total = max($countSuratMasuk, 1);
                        $pBelum = round(($statusBelum / $total) * 100);
                        $pProses = round(($statusProses / $total) * 100);
                        $pSelesai = round(($statusSelesai / $total) * 100);
                    @endphp

                    <div class="mt-3 small text-secondary">Status Disposisi</div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between small">
                            <span>Belum</span><span class="text-secondary">{{ $statusBelum }}</span>
                        </div>
                        <div class="progress rounded-pill" style="height:8px;">
                            <div class="progress-bar" style="width: {{ $pBelum }}%"></div>
                        </div>

                        <div class="d-flex justify-content-between small mt-2">
                            <span>Proses</span><span class="text-secondary">{{ $statusProses }}</span>
                        </div>
                        <div class="progress rounded-pill" style="height:8px;">
                            <div class="progress-bar" style="width: {{ $pProses }}%"></div>
                        </div>

                        <div class="d-flex justify-content-between small mt-2">
                            <span>Selesai</span><span class="text-secondary">{{ $statusSelesai }}</span>
                        </div>
                        <div class="progress rounded-pill" style="height:8px;">
                            <div class="progress-bar" style="width: {{ $pSelesai }}%"></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('surat-masuk.index') }}" class="text-decoration-none">
                            Lihat Surat Masuk <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Surat Keluar</div>
                            <div class="fs-2 fw-bold">{{ number_format($countSuratKeluar) }}</div>
                        </div>
                        <div class="rounded-4 p-3" style="background:#fff3e6;">
                            <i class="bi bi-send fs-3 text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-secondary small">
                        Ringkasan surat keluar organisasi
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('surat-keluar.index') }}" class="text-decoration-none">
                            Lihat Surat Keluar <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Agenda</div>
                            <div class="fs-2 fw-bold">{{ number_format($countAgenda) }}</div>
                        </div>
                        <div class="rounded-4 p-3" style="background:#eef2ff;">
                            <i class="bi bi-calendar-event fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-secondary small">
                        Agenda kegiatan terjadwal
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('agenda.index') }}" class="text-decoration-none">
                            Lihat Agenda <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLES --}}
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-semibold">Surat Masuk Terbaru</div>
                            <div class="text-secondary small">5 data terakhir</div>
                        </div>
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-light border rounded-4">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-secondary small">
                                <tr>
                                    <th>Perihal</th>
                                    <th style="width:160px;">Tgl Diterima</th>
                                    <th style="width:140px;">Status</th>
                                    <th style="width:80px;" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestSuratMasuk as $s)
                                    @php
                                        $status = $s->status_disposisi ?? '-';
                                        $badge = match($status) {
                                            'belum' => 'bg-warning-subtle text-warning',
                                            'proses' => 'bg-info-subtle text-info',
                                            'selesai' => 'bg-success-subtle text-success',
                                            default => 'bg-secondary-subtle text-secondary',
                                        };
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $s->perihal ?? '-' }}</div>
                                            <div class="text-secondary small">
                                                {{ $s->asal_surat ?? '-' }} • {{ $s->nomor_agenda ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="text-secondary">
                                            {{ optional($s->tanggal_diterima)->format('d/m/Y') ?? $s->tanggal_diterima ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 {{ $badge }}">
                                                {{ strtoupper($status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('surat-masuk.show', $s->id) }}" class="btn btn-sm btn-outline-secondary rounded-4">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-4">
                                            Belum ada data surat masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="card border-0 rounded-4 shadow-sm mt-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-semibold">Surat Keluar Terbaru</div>
                            <div class="text-secondary small">5 data terakhir</div>
                        </div>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-light border rounded-4">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-secondary small">
                                <tr>
                                    <th>Perihal</th>
                                    <th style="width:160px;">Tanggal</th>
                                    <th style="width:80px;" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestSuratKeluar as $k)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $k->perihal ?? '-' }}</div>
                                            <div class="text-secondary small">
                                                {{ $k->tujuan_surat ?? '-' }} • {{ $k->nomor_agenda ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="text-secondary">
                                            {{ optional($k->tanggal_surat)->format('d/m/Y') ?? $k->tanggal_surat ?? '-' }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('surat-keluar.show', $k->id) }}" class="btn btn-sm btn-outline-secondary rounded-4">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary py-4">
                                            Belum ada data surat keluar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-semibold">Agenda Terdekat</div>
                            <div class="text-secondary small">5 agenda berikutnya</div>
                        </div>
                        <a href="{{ route('agenda.index') }}" class="btn btn-light border rounded-4">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse($upcomingAgenda as $a)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold">{{ $a->nama_kegiatan ?? '-' }}</div>
                                        <div class="text-secondary small">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $a->tempat ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small text-secondary">
                                            {{ $a->waktu_mulai ? \Illuminate\Support\Carbon::parse($a->waktu_mulai)->format('d/m/Y') : '-' }}
                                        </div>
                                        <div class="small text-secondary">
                                            {{ $a->waktu_mulai ? \Illuminate\Support\Carbon::parse($a->waktu_mulai)->format('H:i') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-secondary py-4">
                                Belum ada agenda.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
