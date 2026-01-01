<x-app-layout>
  <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="h3 fw-bold mb-1">Detail Surat Masuk</h1>
      <div class="text-secondary">{{ $suratMasuk->perihal }}</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('surat-masuk.edit', $suratMasuk) }}" class="btn btn-primary rounded-4 px-4 py-2">
        <i class="bi bi-pencil-square me-2"></i>Edit
      </a>
      <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
      <a href="{{ route('surat-masuk.disposisi.index', $suratMasuk) }}" class="btn btn-outline-primary rounded-4 px-4 py-2">
        <i class="bi bi-diagram-3 me-2"></i>Disposisi
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-lg-5">
      @php
        $st = $suratMasuk->status_disposisi;
        $class = match($st) {
          'belum' => 'bg-warning-subtle border border-warning text-warning-emphasis',
          'proses' => 'bg-info-subtle border border-info text-info-emphasis',
          'selesai' => 'bg-success-subtle border border-success text-success-emphasis',
          default => 'bg-light border text-secondary'
        };
        $label = match($st) {
          'belum' => 'Belum Diproses',
          'proses' => 'Dalam Proses',
          'selesai' => 'Sudah Didisposisi',
          default => $st ?? '-'
        };
      @endphp

      <div class="row g-4">
        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Nomor Agenda</div>
          <div class="fw-semibold">{{ $suratMasuk->nomor_agenda }}</div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Nomor Surat Asal</div>
          <div class="fw-semibold">{{ $suratMasuk->nomor_surat_asal ?? '-' }}</div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Tanggal Surat</div>
          <div class="fw-semibold">
            {{ $suratMasuk->tanggal_surat ? \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('j/n/Y') : '-' }}
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Tanggal Diterima</div>
          <div class="fw-semibold">
            {{ $suratMasuk->tanggal_diterima ? \Carbon\Carbon::parse($suratMasuk->tanggal_diterima)->format('j/n/Y') : '-' }}
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Asal Surat</div>
          <div class="fw-semibold">{{ $suratMasuk->asal_surat }}</div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Kategori</div>
          <div class="fw-semibold">{{ $suratMasuk->kategoriSurat->nama_kategori ?? '-' }}</div>
        </div>

        <div class="col-12">
          <div class="text-secondary small">Perihal</div>
          <div class="fw-semibold">{{ $suratMasuk->perihal }}</div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Status Disposisi</div>
          <span class="badge rounded-pill px-3 py-2 {{ $class }}">{{ $label }}</span>
        </div>

        <div class="col-12 col-lg-6">
          <div class="text-secondary small">Lampiran</div>
          @if($suratMasuk->lampiran_file)
            <a href="{{ asset('storage/'.$suratMasuk->lampiran_file) }}" target="_blank" class="fw-semibold">
              <i class="bi bi-paperclip me-1"></i> Lihat Lampiran
            </a>
          @else
            <div class="fw-semibold">-</div>
          @endif
        </div>

        <div class="col-12">
          <div class="text-secondary small">Isi Ringkas</div>
          <div class="mt-1">{{ $suratMasuk->isi_ringkas ?? '-' }}</div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
