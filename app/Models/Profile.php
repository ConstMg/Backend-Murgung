<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $casts = [
        'headline' => 'array',
    ];

    protected $fillable = [
        'headline',
        'main_description',
        'recent_project_desc',
        'about_desc',
        'visi',
        'misi',
        'nama_kantor',
        'nomor_hp',
        'email',
        'website_url',
        'facebook',
        'instagram',
    ];

    public function aboutImages()
    {
        return $this->hasMany(CloudinaryImage::class)->where('image_type', 'about_us');
    }
}
