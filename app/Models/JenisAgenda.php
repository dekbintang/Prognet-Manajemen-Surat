<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAgenda extends Model
{
    use HasFactory;

    protected $table = 'jenis_agendas';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
    ];

    public function agendaKegiatans()
    {
        return $this->hasMany(AgendaKegiatan::class, 'jenis_agenda_id');
    }
}
