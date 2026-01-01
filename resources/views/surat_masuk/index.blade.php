<x-app-layout>
  <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="h3 fw-bold mb-1">Surat Masuk</h1>
      <div class="text-secondary">Kelola semua surat masuk organisasi</div>
    </div>

    <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
      <i class="bi bi-plus-lg me-2"></i>Tambah Surat Masuk
    </a>
  </div>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-12 col-lg-8">
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0 rounded-start-4">
          <i class="bi bi-search text-secondary"></i>
        </span>
        <input type="text" name="q" value="{{ request('q') }}"
               class="form-control border-start-0 rounded-end-4 py-2"
               placeholder="Cari surat...">
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <select name="status_disposisi" class="form-select rounded-4 py-2">
        <option value="">Semua Status</option>
        <option value="belum"   @selected(request('status_disposisi')==='belum')>Belum Diproses</option>
        <option value="proses"  @selected(request('status_disposisi')==='proses')>Dalam Proses</option>
        <option value="selesai" @selected(request('status_disposisi')==='selesai')>Sudah Didisposisi</option>
      </select>
    </div>

    <div class="col-12">
      <button class="btn btn-outline-secondary rounded-4 px-4 py-2" type="submit">
        <i class="bi bi-funnel me-2"></i>Terapkan
      </button>
      <a class="btn btn-link text-decoration-none" href="{{ route('surat-masuk.index') }}">Reset</a>
    </div>
  </form>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="text-secondary small" style="background:#f8fafc;">
          <tr>
            <th class="px-4 py-3 fw-semibold">Asal Surat</th>
            <th class="px-4 py-3 fw-semibold">Perihal</th>
            <th class="px-4 py-3 fw-semibold">Tanggal Diterima</th>
            <th class="px-4 py-3 fw-semibold">Status</th>
            <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
          </tr>
        </thead>

        <tbody>
        @forelse($suratMasuks as $item)
          <tr>
            <td class="px-4 py-4">
              <div class="fw-semibold">{{ $item->asal_surat }}</div>
              <div class="text-secondary small">{{ $item->nomor_surat_asal ?? '-' }}</div>
            </td>

            <td class="px-4 py-4">
              <div class="fw-semibold">{{ $item->perihal }}</div>
              <div class="text-secondary small">{{ $item->nomor_agenda }}</div>
            </td>

            <td class="px-4 py-4">
              {{ $item->tanggal_diterima ? \Carbon\Carbon::parse($item->tanggal_diterima)->format('j/n/Y') : '-' }}
            </td>

            <td class="px-4 py-4">
              @php
                $st = $item->status_disposisi;
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

              <span class="badge rounded-pill px-3 py-2 {{ $class }}">{{ $label }}</span>
            </td>

            <td class="px-4 py-4">
              <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-light border rounded-4" href="{{ route('surat-masuk.show', $item) }}" title="Lihat">
                  <i class="bi bi-eye"></i>
                </a>
                <a class="btn btn-light border rounded-4" href="{{ route('surat-masuk.edit', $item) }}" title="Edit">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <form method="POST" action="{{ route('surat-masuk.destroy', $item) }}"
                      onsubmit="return confirm('Hapus surat ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-light border rounded-4" type="submit" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-secondary py-5">
              Belum ada data surat masuk.
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-body pt-3">
      {{ $suratMasuks->links() }}
    </div>
  </div>
</x-app-layout>
