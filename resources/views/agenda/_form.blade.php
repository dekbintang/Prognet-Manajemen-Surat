@php
  $isEdit = isset($agendaKegiatan);
  $wm = old('waktu_mulai', isset($agendaKegiatan->waktu_mulai) ? \Carbon\Carbon::parse($agendaKegiatan->waktu_mulai)->format('Y-m-d\TH:i') : '');
  $ws = old('waktu_selesai', isset($agendaKegiatan->waktu_selesai) ? \Carbon\Carbon::parse($agendaKegiatan->waktu_selesai)->format('Y-m-d\TH:i') : '');
@endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold">Nama Kegiatan</label>
        <input class="form-control rounded-4 py-2" name="nama_kegiatan"
               value="{{ old('nama_kegiatan', $agendaKegiatan->nama_kegiatan ?? '') }}" required>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Jenis Agenda</label>
        <select name="jenis_agenda_id" class="form-select rounded-4 py-2" required>
            <option value="">-- Pilih Jenis --</option>
            @foreach($jenisAgendas as $j)
                <option value="{{ $j->id }}" @selected(old('jenis_agenda_id', $agendaKegiatan->jenis_agenda_id ?? '') == $j->id)>
                    {{ $j->nama_jenis }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-lg-3">
        <label class="form-label fw-semibold">Waktu Mulai</label>
        <input type="datetime-local" class="form-control rounded-4 py-2" name="waktu_mulai" value="{{ $wm }}" required>
    </div>

    <div class="col-12 col-lg-3">
        <label class="form-label fw-semibold">Waktu Selesai</label>
        <input type="datetime-local" class="form-control rounded-4 py-2" name="waktu_selesai" value="{{ $ws }}">
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Tempat</label>
        <input class="form-control rounded-4 py-2" name="tempat" value="{{ old('tempat', $agendaKegiatan->tempat ?? '') }}">
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Status</label>
        @php $st = old('status', $agendaKegiatan->status ?? 'aktif'); @endphp
        <select name="status" class="form-select rounded-4 py-2" required>
            <option value="aktif" @selected($st==='aktif')>Aktif</option>
            <option value="selesai" @selected($st==='selesai')>Selesai</option>
            <option value="batal" @selected($st==='batal')>Batal</option>
        </select>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Tautkan Surat Masuk (opsional)</label>
        <select name="surat_masuk_id" class="form-select rounded-4 py-2">
            <option value="">-- Tidak Ada --</option>
            @foreach($suratMasuks as $s)
                <option value="{{ $s->id }}" @selected(old('surat_masuk_id', $agendaKegiatan->surat_masuk_id ?? '') == $s->id)>
                    {{ $s->nomor_agenda }} - {{ $s->perihal }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-lg-6">
        <label class="form-label fw-semibold">Tautkan Surat Keluar (opsional)</label>
        <select name="surat_keluar_id" class="form-select rounded-4 py-2">
            <option value="">-- Tidak Ada --</option>
            @foreach($suratKeluars as $s)
                <option value="{{ $s->id }}" @selected(old('surat_keluar_id', $agendaKegiatan->surat_keluar_id ?? '') == $s->id)>
                    {{ $s->nomor_agenda }} - {{ $s->perihal }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Keterangan</label>
        <textarea class="form-control rounded-4" rows="4" name="keterangan">{{ old('keterangan', $agendaKegiatan->keterangan ?? '') }}</textarea>
    </div>
</div>
