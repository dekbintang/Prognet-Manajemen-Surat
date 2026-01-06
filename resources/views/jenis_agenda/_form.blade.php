@php
    $isEdit = isset($jenisAgenda);
@endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Jenis</label>
    <input class="form-control rounded-4 py-2 @error('nama_jenis') is-invalid @enderror"
           name="nama_jenis"
           value="{{ old('nama_jenis', $jenisAgenda->nama_jenis ?? '') }}"
           required>
    @error('nama_jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea class="form-control rounded-4 @error('deskripsi') is-invalid @enderror"
              rows="4"
              name="deskripsi">{{ old('deskripsi', $jenisAgenda->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
