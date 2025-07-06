<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KaryawanSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [
                'nama' => 'Tri Wanto Ardi Wibawa',
                'nik' => '3316112011770003',
                'jk' => 'Laki-Laki',
                'alamat' => 'Cluster Grand Harmony 2 Blok 2 No. 69 RT 002 RW 015 Desa Sukamantri',
                'divisi' => 'Komisaris',
                'penempatan' => 'BOGOR',
                'email' => 'triwanto@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Kukuh Sri Dayanto',
                'nik' => '3275023007770030',
                'jk' => 'Laki-Laki',
                'alamat' => 'Jl Pirus D 420 RT 010 RW 009 Desa Jaka Sampurna',
                'divisi' => 'Direktur',
                'penempatan' => 'BOGOR',
                'email' => 'kukuh@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Nila Sri Asmawati',
                'nik' => '3201046107000004',
                'jk' => 'Perempuan',
                'alamat' => 'Jl Jambudipa RT 001 RW 008 Desa Cilebut Timur',
                'divisi' => 'Finance',
                'penempatan' => 'BOGOR',
                'email' => 'nila@constmg.com',
                'password' => 'constmg123',
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Ajeng Kartika',
                'nik' => '3204296104000006',
                'jk' => 'Perempuan',
                'alamat' => 'Kp. Buntrak RT 001 RW 013 Desa Sagaracipta',
                'divisi' => 'Accounting',
                'penempatan' => 'BOGOR',
                'email' => 'ajeng@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Eko Wartono',
                'nik' => '3316111205750005',
                'jk' => 'Laki-Laki',
                'alamat' => 'Mojowetan RT 008 RW 002 Desa Mojowetan',
                'divisi' => 'MG. Operasional',
                'penempatan' => 'BOGOR',
                'email' => 'eko@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Machfud Husni',
                'nik' => '3372051409870006',
                'jk' => 'Laki-Laki',
                'alamat' => 'Grogolan RT 004 RW 001 Desa Katelan',
                'divisi' => 'Op. Support',
                'penempatan' => 'BOGOR',
                'email' => 'machfud@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Ade Purwanto Setiyawan',
                'nik' => '3316161603940003',
                'jk' => 'Laki-Laki',
                'alamat' => 'DK Nglaroh RT 004 RW 002 Desa Balong',
                'divisi' => 'QC',
                'penempatan' => 'KALIMANTAN',
                'email' => 'ade@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Ribut Eko Saputro',
                'nik' => '3374112310760002',
                'jk' => 'Laki-Laki',
                'alamat' => 'Srondol Kulon RT 005 RW 002 Desa Srondol Kulon',
                'divisi' => 'Engginering',
                'penempatan' => 'BOGOR',
                'email' => 'ribut@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Wiwi Artiningsih',
                'nik' => '301084610890001',
                'jk' => 'Perempuan',
                'alamat' => 'Perum Bukit Waringin Blok G 15 No.2 RT 008 RW 014 Desa Cimanggis',
                'divisi' => 'Commercial',
                'penempatan' => 'BOGOR',
                'email' => 'wiwi@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'M Imam Wahyudi',
                'nik' => '3316121401930001',
                'jk' => 'Laki-Laki',
                'alamat' => 'DK Banjarwaru RT 006 RW 001 Desa Sarimulyo',
                'divisi' => 'QC',
                'penempatan' => 'KALIMANTAN',
                'email' => 'imam@constmg.com',
                'password' => 'constmg123',
                'role'         => 'karyawan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        // DB::table('karyawan')->insert();
        $hashedData = collect($data)->map(function ($item) {
            $item['password'] = Hash::make($item['password']);
            $item['created_at'] = Carbon::now();
            $item['updated_at'] = Carbon::now();
            return $item;
        })->toArray();

        DB::table('karyawan')->insert($hashedData);
    }
}
