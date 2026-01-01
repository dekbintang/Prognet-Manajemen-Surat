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

<div class="mb-3">
  <label class="form-label fw-semibold">Nama Kategori</label>
  <input type="text"
         class="form-control rounded-4 py-2"
         name="nama_kategori"
         value="{{ old('nama_kategori', $kategoriSurat->nama_kategori ?? '') }}"
         required>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Deskripsi</label>
  <textarea class="form-control rounded-4"
            name="deskripsi"
            rows="4">{{ old('deskripsi', $kategoriSurat->deskripsi ?? '') }}</textarea>
</div>
