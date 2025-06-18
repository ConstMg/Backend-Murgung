<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Login extends Model
{
    use HasFactory;

    protected $table = 'logins';

    protected $fillable = [
        'karyawan_id',
        'email',
        'waktu_login',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
