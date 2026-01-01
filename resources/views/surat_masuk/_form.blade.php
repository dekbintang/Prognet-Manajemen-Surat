@php $isEdit = isset($suratMasuk); @endphp

<div class="row g-3">
  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Nomor Agenda</label>
    <input name="nomor_agenda" class="form-control rounded-4 py-2"
           value="{{ old('nomor_agenda', $suratMasuk->nomor_agenda ?? '') }}" required>
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Nomor Surat Asal</label>
    <input name="nomor_surat_asal" class="form-control rounded-4 py-2"
           value="{{ old('nomor_surat_asal', $suratMasuk->nomor_surat_asal ?? '') }}">
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Tanggal Surat</label>
    <input type="date" name="tanggal_surat" class="form-control rounded-4 py-2"
           value="{{ old('tanggal_surat', isset($suratMasuk->tanggal_surat) ? \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('Y-m-d') : '') }}">
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Tanggal Diterima</label>
    <input type="date" name="tanggal_diterima" class="form-control rounded-4 py-2"
           value="{{ old('tanggal_diterima', isset($suratMasuk->tanggal_diterima) ? \Carbon\Carbon::parse($suratMasuk->tanggal_diterima)->format('Y-m-d') : '') }}">
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Asal Surat</label>
    <input name="asal_surat" class="form-control rounded-4 py-2"
           value="{{ old('asal_surat', $suratMasuk->asal_surat ?? '') }}" required>
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Kategori</label>
    <select name="kategori_id" class="form-select rounded-4 py-2" required>
      <option value="">-- Pilih Kategori --</option>
      @foreach($kategoris as $k)
        <option value="{{ $k->id }}"
          @selected(old('kategori_id', $suratMasuk->kategori_id ?? '') == $k->id)>
          {{ $k->nama_kategori }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12">
    <label class="form-label fw-semibold">Perihal</label>
    <input name="perihal" class="form-control rounded-4 py-2"
           value="{{ old('perihal', $suratMasuk->perihal ?? '') }}" required>
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Status Disposisi</label>
    @php $st = old('status_disposisi', $suratMasuk->status_disposisi ?? 'belum'); @endphp
    <select name="status_disposisi" class="form-select rounded-4 py-2" required>
      <option value="belum" @selected($st==='belum')>Belum Diproses</option>
      <option value="proses" @selected($st==='proses')>Dalam Proses</option>
      <option value="selesai" @selected($st==='selesai')>Sudah Didisposisi</option>
    </select>
  </div>

  <div class="col-12 col-lg-6">
    <label class="form-label fw-semibold">Lampiran (PDF/JPG/PNG)</label>
    <input type="file" name="lampiran_file" class="form-control rounded-4 py-2">
    @if($isEdit && !empty($suratMasuk->lampiran_file))
      <div class="small mt-2">
        Lampiran saat ini:
        <a href="{{ asset('storage/'.$suratMasuk->lampiran_file) }}" target="_blank">Lihat</a>
      </div>
    @endif
  </div>

  <div class="col-12">
    <label class="form-label fw-semibold">Isi Ringkas</label>
    <textarea name="isi_ringkas" rows="4" class="form-control rounded-4">{{ old('isi_ringkas', $suratMasuk->isi_ringkas ?? '') }}</textarea>
  </div>
</div>
