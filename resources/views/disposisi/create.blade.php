<x-app-layout>
  <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="h3 fw-bold mb-1">Buat Disposisi</h1>
      <div class="text-secondary">
        {{ $suratMasuk->nomor_agenda }} — {{ $suratMasuk->perihal }}
      </div>
    </div>

    <a href="{{ route('surat-masuk.disposisi.index', $suratMasuk) }}" class="btn btn-outline-secondary rounded-4 px-4 py-2">
      <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger rounded-4">
      <div class="fw-semibold mb-2">Terjadi kesalahan:</div>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-lg-5">
      <form method="POST" action="{{ route('surat-masuk.disposisi.store', $suratMasuk) }}">
        @csrf

        <div class="row g-3">
          <div class="col-12 col-lg-6">
            <label class="form-label fw-semibold">Kepada (Unit/Jabatan/Nama)</label>
            <input name="kepada" class="form-control rounded-4 py-2"
                   value="{{ old('kepada') }}" placeholder="Contoh: Kepala TU / Sekretariat" required>
          </div>

          <div class="col-12 col-lg-6">
            <label class="form-label fw-semibold">Pilih User (Opsional)</label>
            <select name="kepada_user_id" class="form-select rounded-4 py-2">
              <option value="">-- Tidak dipilih --</option>
              @foreach($users as $u)
                <option value="{{ $u->id }}" @selected(old('kepada_user_id') == $u->id)>
                  {{ $u->name }} ({{ $u->email }})
                </option>
              @endforeach
            </select>
            <div class="text-secondary small mt-1">Kalau dipilih, nama user akan tampil sebagai tujuan.</div>
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Instruksi</label>
            <textarea name="instruksi" rows="4" class="form-control rounded-4"
                      placeholder="Contoh: Mohon ditindaklanjuti dan buat balasan...">{{ old('instruksi') }}</textarea>
          </div>

          <div class="col-12 col-lg-4">
            <label class="form-label fw-semibold">Batas Waktu (Opsional)</label>
            <input type="date" name="batas_waktu" class="form-control rounded-4 py-2"
                   value="{{ old('batas_waktu') }}">
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-primary rounded-4 px-4 py-2 fw-semibold" type="submit">
            <i class="bi bi-send me-2"></i>Kirim Disposisi
          </button>
          <a href="{{ route('surat-masuk.disposisi.index', $suratMasuk) }}" class="btn btn-light border rounded-4 px-4 py-2">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
