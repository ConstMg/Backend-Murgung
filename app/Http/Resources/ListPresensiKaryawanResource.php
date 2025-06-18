<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListPresensiKaryawanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'nama'           => $this->karyawan->nama,
            'email'          => $this->karyawan->email,
            'tanggal'        => $this->tanggal,
            'jam_masuk'      => $this->jam_masuk,
            'jam_keluar'     => $this->jam_keluar,
            'status_presensi' => $this->status_presensi,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'deskripsi'      => $this->deskripsi,
        ];
    }
}
