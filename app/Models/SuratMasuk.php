<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuks';

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat_asal',
        'tanggal_surat',
        'tanggal_diterima',
        'asal_surat',
        'perihal',
        'kategori_id',
        'isi_ringkas',
        'lampiran_file',
        'status_disposisi',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function agendas()
    {
        return $this->hasMany(AgendaKegiatan::class, 'surat_masuk_id');
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }
}
