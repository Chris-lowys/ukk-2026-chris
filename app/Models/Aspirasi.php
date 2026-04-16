<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $primaryKey = 'id_aspirasi';

    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'status',
        'feedback',
        'lampiran'     
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}