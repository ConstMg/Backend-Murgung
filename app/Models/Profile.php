<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Nama tabel (opsional jika mengikuti konvensi Laravel)
    protected $table = 'profiles';

    public function aboutImages()
    {
        return $this->hasMany(CloudinaryImage::class)->where('image_type', 'about_us');
    }
    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'headline',
        'main_description',
        'recent_project_desc',
        'about_desc',
        'nama_kantor',
        'nomor_hp',
        'email',
        'website_url',
    ];
}
