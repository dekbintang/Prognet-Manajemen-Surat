@php $isEdit = isset($kategoriSurat); @endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Kategori</label>
    <input class="form-control rounded-4 py-2" name="nama_kategori"
           value="{{ old('nama_kategori', $kategoriSurat->nama_kategori ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea class="form-control rounded-4" rows="4" name="deskripsi">{{ old('deskripsi', $kategoriSurat->deskripsi ?? '') }}</textarea>
</div>
