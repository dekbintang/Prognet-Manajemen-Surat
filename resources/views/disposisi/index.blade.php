<x-app-layout>
  <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="h3 fw-bold mb-1">Disposisi Surat Masuk</h1>
      <div class="text-secondary">
        {{ $suratMasuk->nomor_agenda }} — {{ $suratMasuk->perihal }}
      </div>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('surat-masuk.show', $suratMasuk) }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
      <a href="{{ route('surat-masuk.disposisi.create', $suratMasuk) }}" class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">
        <i class="bi bi-plus-lg me-2"></i>Buat Disposisi
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="text-secondary small" style="background:#f8fafc;">
          <tr>
            <th class="px-4 py-3">Kepada</th>
            <th class="px-4 py-3">Instruksi</th>
            <th class="px-4 py-3">Batas Waktu</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($disposisis as $d)
            @php
              $badge = match($d->status) {
                'dikirim' => 'bg-warning-subtle border border-warning text-warning-emphasis',
                'dibaca' => 'bg-info-subtle border border-info text-info-emphasis',
                'diproses' => 'bg-primary-subtle border border-primary text-primary-emphasis',
                'selesai' => 'bg-success-subtle border border-success text-success-emphasis',
                default => 'bg-light border text-secondary'
              };
            @endphp

            <tr>
              <td class="px-4 py-3">
                <div class="fw-semibold">
                  {{ $d->kepadaUser?->name ?? $d->kepada }}
                </div>
                <div class="text-secondary small">
                  Dari: {{ $d->dariUser?->name ?? '-' }} •
                  {{ $d->tanggal_disposisi ? \Carbon\Carbon::parse($d->tanggal_disposisi)->format('d/m/Y H:i') : '-' }}
                </div>
              </td>

              <td class="px-4 py-3">
                <div>{{ $d->instruksi ?? '-' }}</div>
              </td>

              <td class="px-4 py-3">
                {{ $d->batas_waktu ? \Carbon\Carbon::parse($d->batas_waktu)->format('d/m/Y') : '-' }}
              </td>

              <td class="px-4 py-3">
                <span class="badge rounded-pill px-3 py-2 {{ $badge }}">
                  {{ ucfirst($d->status) }}
                </span>
                @if($d->status === 'selesai' && $d->tanggal_selesai)
                  <div class="text-secondary small mt-1">
                    Selesai: {{ \Carbon\Carbon::parse($d->tanggal_selesai)->format('d/m/Y H:i') }}
                  </div>
                @endif
              </td>

              <td class="px-4 py-3">
                <div class="d-flex justify-content-end gap-2">

                  <form method="POST" action="{{ route('surat-masuk.disposisi.update', [$suratMasuk, $d]) }}" class="d-flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm rounded-4" style="width: 140px;">
                      @foreach(['dikirim','dibaca','diproses','selesai'] as $st)
                        <option value="{{ $st }}" @selected($d->status === $st)>{{ ucfirst($st) }}</option>
                      @endforeach
                    </select>
                    <button class="btn btn-sm btn-outline-secondary rounded-4" type="submit">
                      <i class="bi bi-check2"></i>
                    </button>
                  </form>

                  <form method="POST" action="{{ route('surat-masuk.disposisi.destroy', [$suratMasuk, $d]) }}"
                        onsubmit="return confirm('Hapus disposisi ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-light border rounded-4" type="submit" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-secondary py-5">
                Belum ada disposisi untuk surat ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-body pt-3">
      {{ $disposisis->links() }}
    </div>
  </div>
</x-app-layout>
