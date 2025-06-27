<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudinaryImage extends Model
{
        use HasFactory;

        protected $fillable = [
                'asset_id',
                'public_id',
                'asset_folder',
                'display_name',
                'url',
                'secure_url',
                'project_id',
                'profile_id',
                'image_type',
        ];

        public function profile()
        {
                return $this->belongsTo(Profile::class);
        }
        public function project()
        {
                return $this->belongsTo(Project::class);
        }
}
