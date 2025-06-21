<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        "deskripsi",
        'pemberi_kerja',
        'tanggal_dimulai_proyek',
        'tanggal_selesai_proyek',
        'kategori',
        'nilai_kontrak',
    ];


    public function images()
    {
        return $this->hasMany(CloudinaryImage::class);
    }
}
