@php $isEdit = isset($suratKeluar); @endphp

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Nomor Agenda</label>
        <input class="form-control rounded-4 py-2" name="nomor_agenda"
               value="{{ old('nomor_agenda', $suratKeluar->nomor_agenda ?? '') }}" required>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Nomor Surat</label>
        <input class="form-control rounded-4 py-2" name="nomor_surat"
               value="{{ old('nomor_surat', $suratKeluar->nomor_surat ?? '') }}">
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Tanggal Surat</label>
        <input type="date" class="form-control rounded-4 py-2" name="tanggal_surat"
               value="{{ old('tanggal_surat', isset($suratKeluar->tanggal_surat) ? \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('Y-m-d') : '') }}">
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Status</label>
        <select name="status" class="form-select rounded-4 py-2" required>
            @php $st = old('status', $suratKeluar->status ?? 'draft'); @endphp
            <option value="draft" @selected($st==='draft')>Draft</option>
            <option value="disetujui" @selected($st==='disetujui')>Disetujui</option>
            <option value="dikirim" @selected($st==='dikirim')>Dikirim</option>
        </select>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Tujuan Surat</label>
        <input class="form-control rounded-4 py-2" name="tujuan_surat"
               value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat ?? '') }}" required>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori_id" class="form-select rounded-4 py-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}" @selected(old('kategori_id', $suratKeluar->kategori_id ?? '') == $k->id)>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Perihal</label>
        <input class="form-control rounded-4 py-2" name="perihal"
               value="{{ old('perihal', $suratKeluar->perihal ?? '') }}" required>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Lampiran (PDF/JPG/PNG)</label>
        <input type="file" class="form-control rounded-4 py-2" name="lampiran_file">
        @if($isEdit && $suratKeluar->lampiran_file)
            <div class="small mt-2">
                Lampiran saat ini:
                <a href="{{ asset('storage/'.$suratKeluar->lampiran_file) }}" target="_blank">Lihat</a>
            </div>
        @endif
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Isi Ringkas</label>
        <textarea class="form-control rounded-4" rows="4" name="isi_ringkas">{{ old('isi_ringkas', $suratKeluar->isi_ringkas ?? '') }}</textarea>
    </div>
</div>
