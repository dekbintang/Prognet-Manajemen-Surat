<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    use HasFactory;

    protected $table = 'kategori_surats';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_id');
    }
}
