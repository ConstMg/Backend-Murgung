<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id', 'tanggal', 'jam_masuk', 'jam_keluar', 'status_presensi', 'latitude', 'longitude', 'deskripsi',
    ];
    protected $table = 'presensis';
    
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}