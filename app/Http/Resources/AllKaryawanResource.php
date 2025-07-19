<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllKaryawanResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'nama'  => $this->nama,
            'nik'   => $this->nik,
            'jk'   => $this->jk,
            'alamat'   => $this->alamat,
            'divisi'   => $this->divisi,
            'penempatan'   => $this->penempatan,
            'email' => $this->email,
            'password'   => $this->password,
            'role'   => $this->role,
            'status' => $this->status,
            // tambahkan field lainnya jika perlu
        ];
    }
}
