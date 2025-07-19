<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'nama'        => $this->nama,
            'nik'         => $this->nik,
            'jk'          => $this->jk,
            'alamat'      => $this->alamat,
            'divisi'      => $this->divisi,
            'penempatan'  => $this->penempatan,
            'email'       => $this->email,
            'role'        => $this->role,
            'status'      => $this->status,
            
        ];
    }
}
