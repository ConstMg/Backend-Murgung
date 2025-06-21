<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project_id' => $this->id,
            'project_name' => $this->name,
            'deskripsi' => $this->deskripsi ?? '-',
            'pemberi_kerja' => $this->pemberi_kerja ?? '-',
            'tanggal_dimulai_proyek' => $this->tanggal_dimulai_proyek ?? '-',
            'tanggal_selesai_proyek' => $this->tanggal_selesai_proyek ?? '-',
            'kategori' => $this->kategori ?? '-',
            'nilai_kontrak' => $this->nilai_kontrak ?? '-',
            'images' => $this->images->map(function ($image) {
                return [
                    'public_id' => $image->public_id,
                    'secure_url' => $image->secure_url ?? '',
                ];
            })->values(),
        ];
    }
}
