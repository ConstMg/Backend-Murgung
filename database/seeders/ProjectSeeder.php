<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Project RS Pendidikan Makassar',
                'pemberi_kerja' => 'PT. Ukhuwah Umi Teknik',
                'tanggal_dimulai_proyek' => '2016-01-15',
                'tanggal_selesai_proyek' => '2017-11-10',
                'kategori' => 'gedung',
                'nilai_kontrak' => 15166612000,
                'deskripsi' => "Pekerjaan Fasad RS UMI Makassar Tahap I, II dan Koridor\r\n"
            ],
            [
                'name' => 'Project ACP Sumbawa',
                'pemberi_kerja' => 'PT. PP (Persero) Tbk.',
                'tanggal_dimulai_proyek' => '2023-03-20',
                'tanggal_selesai_proyek' => '2023-04-30',
                'kategori' => 'gedung',
                'nilai_kontrak' => 154507449,
                'deskripsi' => "Pembuatan Gardu"
            ],
            [
                'name' => 'Project Aspal Terowongan Masjd Istiqlal',
                'pemberi_kerja' => 'PT. Waskita Karya Building Division',
                'tanggal_dimulai_proyek' => '2021-04-08',
                'tanggal_selesai_proyek' => '2021-04-21',
                'kategori' => 'jalan',
                'nilai_kontrak' => 291490712,
                'deskripsi' => "Pekerjaan Pengaspalan, Proyek Terowongan Silaturahmi Masjid Istiqlal\r\n"
            ],
            [
                'name' => 'Project Renovasi Rumah Dinas Kebon Sirih IV No. 13',
                'pemberi_kerja' => 'PT. Bank Mandiri (Persero) Tbk',
                'tanggal_dimulai_proyek' => '2022-08-12',
                'tanggal_selesai_proyek' => '2022-09-09',
                'kategori' => 'rumah',
                'nilai_kontrak' => 160000000,
                'deskripsi' => "Jasa Kontraktor Pelaksana Renovasi Rumah Dinas Jl. Kebon Sirih IV No. 13\r\n"
            ],
            [
                'name' => 'Project Atap Halte BRT Tosari',
                'pemberi_kerja' => 'PT. Waskita Karya (Persero) Tbk',
                'tanggal_dimulai_proyek' => '2022-08-22',
                'tanggal_selesai_proyek' => '2022-12-29',
                'kategori' => 'other',
                'nilai_kontrak' => 607167130,
                'deskripsi' => "Pekerjaan Tambah Atap UPVC Beserta Rangka dan Talang Halte Tosari\r\n"
            ],
            [
                'name' => 'Project Atap Halte TJ Dukuh Atas',
                'pemberi_kerja' => 'PT. Waskita Karya (Persero) TBK',
                'tanggal_dimulai_proyek' => '2022-10-01',
                'tanggal_selesai_proyek' => '2022-10-10',
                'kategori' => 'other',
                'nilai_kontrak' => 1236179668,
                'deskripsi' => "Pekerjaan Atap UPVC Beserta Rangka dan Talang Halte Dukuh Atas\r\n"
            ],
            [
                'name' => 'Project Bias Selaras',
                'pemberi_kerja' => 'PT. Bias Tekno Art Kreasindo',
                'tanggal_dimulai_proyek' => '0001-01-01',
                'tanggal_selesai_proyek' => '0001-01-01', // Contoh tanggal tidak valid/kosong
                'kategori' => 'gedung',
                'nilai_kontrak' => 365000000,
                'deskripsi' => "Partisi Kaca"
            ],
            [
                'name' => 'Project BIJB',
                'pemberi_kerja' => 'WIKA - PP KSO',
                'tanggal_dimulai_proyek' => '2018-03-01',
                'tanggal_selesai_proyek' => '2018-08-01',
                'kategori' => 'gedung',
                'nilai_kontrak' => 980852400,
                'deskripsi' => "Pemasangan ACP BIJB Kertajati, Majalengka\r\n"
            ],
            [
                'name' => 'Project Cempaka Putih Tengah XXVII C 29',
                'pemberi_kerja' => 'PT. Bank Mandiri (Persero) Tbk',
                'tanggal_dimulai_proyek' => '2022-08-12',
                'tanggal_selesai_proyek' => '2023-03-13',
                'kategori' => 'rumah',
                'nilai_kontrak' => 600000000,
                'deskripsi' => "Jasa Kontraktor Pelaksana Renovasi Rumah Dinas Bank Mandiri Jl. Cempaka Putih Tengah XXVII C No. 29\r\n"
            ],
            [
                'name' => 'Project Halte Non BRT Cawang',
                'pemberi_kerja' => 'PT. Waskita Karya (Persero) TBK',
                'tanggal_dimulai_proyek' => '2022-07-25',
                'tanggal_selesai_proyek' => '2022-08-06',
                'kategori' => 'other',
                'nilai_kontrak' => 664499380,
                'deskripsi' => "Pekerjaan Halte Non BRT dan Tangga Akses Stasiun Cawang\r\n"
            ],
            [
                'name' => 'Project LIPI Cibinong',
                'pemberi_kerja' => 'PT. PP Persero Tbk',
                'tanggal_dimulai_proyek' => '2020-11-07',
                'tanggal_selesai_proyek' => '2020-11-30',
                'kategori' => 'other',
                'nilai_kontrak' => 47400000,
                'deskripsi' => "Proyek Pembangunan Infrastruktur Laboratorium Geonemic dan BNC, Pekerjaan Pasang ACP Gapura\r\n"
            ],
            [
                'name' => 'Project LRT Jabodetabek',
                'pemberi_kerja' => 'PT. Adhi Persada Gedung',
                'tanggal_dimulai_proyek' => '2020-02-12',
                'tanggal_selesai_proyek' => '2021-03-29',
                'kategori' => 'other',
                'nilai_kontrak' => 2560300000,
                'deskripsi' => "Pekerjaan housing lamp hexagonal St. Ciracas, St. Cibubur, St. TMII, St. Kp. Rambutan, St. Cawang & St. Dukuh Atas\r\n"
            ],
            [
                'name' => 'Project Mercure Hotel CBI Office',
                'pemberi_kerja' => 'PT. Pesona Citra Propertindo',
                'tanggal_dimulai_proyek' => '2022-10-03',
                'tanggal_selesai_proyek' => '2022-12-02',
                'kategori' => 'gedung',
                'nilai_kontrak' => 1030524930,
                'deskripsi' => "ACP dan Curtainwall\r\n"
            ],
            [
                'name' => 'Project MRT Jakarta',
                'pemberi_kerja' => 'OBAYASHI-SHIMIZU-JAYA KONSTRUKSI JOINT VENTURE',
                'tanggal_dimulai_proyek' => '2018-03-03',
                'tanggal_selesai_proyek' => '2019-05-16',
                'kategori' => 'other',
                'nilai_kontrak' => 3184306000,
                'deskripsi' => "Pekerjaan housing lamp hexagonal Stasiun MRT Jakarta\r\n"
            ],
            [
                'name' => 'Project Pagar PPDU',
                'pemberi_kerja' => 'PT. Duta Pilar Jaya',
                'tanggal_dimulai_proyek' => '2022-06-08',
                'tanggal_selesai_proyek' => '2022-06-22',
                'kategori' => 'other',
                'nilai_kontrak' => 588771489,
                'deskripsi' => "Pabrikasi Dan Pemasangan Pagar PPDU Trotoar Sisi Kanan dan Sisi Kiri Dukuh Atas 1, Area Soldier Pile Halte Cawang Cikoko\r\n"
            ],
            [
                'name' => 'Project Pegadaian Bojongherang',
                'pemberi_kerja' => 'PT. Pesonna Indah Jaya ',
                'tanggal_dimulai_proyek' => '0001-01-01',
                'tanggal_selesai_proyek' => '0001-01-01', // Contoh tanggal tidak valid/kosong
                'kategori' => 'other',
                'nilai_kontrak' => 21421224,
                'deskripsi' => "Pengadaan Pintu Kaca Double Swing dan Partisi Kaca\r\n"
            ],
            [
                'name' => 'Project Pegadaian Kandangan',
                'pemberi_kerja' => 'CV. Syakho Teknik',
                'tanggal_dimulai_proyek' => '2022-01-25',
                'tanggal_selesai_proyek' => '2022-02-15',
                'kategori' => 'gedung',
                'nilai_kontrak' => 163185000,
                'deskripsi' => "Pekerjaan Standarisasi Eksterior /Interior PT Pegadaian UPC Kandangan\r\n"
            ],
            [
                'name' => 'Project Pegadaian Kerek',
                'pemberi_kerja' => 'CV. Syakho Teknik',
                'tanggal_dimulai_proyek' => '2022-04-15',
                'tanggal_selesai_proyek' => '2022-05-15',
                'kategori' => 'gedung',
                'nilai_kontrak' => 54769128,
                'deskripsi' => "Standarisasi Eksterior / Interior PT. Pegadaian UPC Kerek\r\n"
            ],
            [
                'name' => 'Project RSPP Palembang',
                'pemberi_kerja' => 'PT. Wijaya Karya Bangunan Gedung',
                'tanggal_dimulai_proyek' => '2018-04-10',
                'tanggal_selesai_proyek' => '2019-06-30',
                'kategori' => 'gedung',
                'nilai_kontrak' => 1549200000,
                'deskripsi' => "Pengadaan dan pemasangan partisi dan plafond gypsum RS. Pelabuhan Palembang\r\n"
            ],
            [
                'name' => 'Project Summarecon Emmerald Karawang',
                'pemberi_kerja' => 'PT. Praja Vita Mulia',
                'tanggal_dimulai_proyek' => '2022-08-02',
                'tanggal_selesai_proyek' => '2022-11-25',
                'kategori' => 'gedung',
                'nilai_kontrak' => 474076000,
                'deskripsi' => "Pekerjaan ACP Summarecon Emmerald Kerawang\r\n"
            ],
            [
                'name' => 'Project TC & Asrama',
                'pemberi_kerja' => 'PT. Tunas Agro Subur Kencana',
                'tanggal_dimulai_proyek' => '2025-05-15',
                'tanggal_selesai_proyek' => '2025-05-08',
                'kategori' => 'other',
                'nilai_kontrak' => 4200000000,
                'deskripsi' => "Pembangunan Training Center dan Asrama uk. 1,153 m2\r\n"
            ],
            [
                'name' => 'Project Tol KAPB',
                'pemberi_kerja' => 'PT. Waskita Karya (Persero) Tbk.',
                'tanggal_dimulai_proyek' => '2021-09-09',
                'tanggal_selesai_proyek' => '2022-02-21',
                'kategori' => 'rumah',
                'nilai_kontrak' => 841128294,
                'deskripsi' => "Pekerjaan Pembangunan Ruangan Site Office, Direksi Keet Tol KAPB Paket IV Seksi 3B\r\n"
            ],
            [
                'name' => 'Project Track Gondola Rooftop',
                'pemberi_kerja' => 'PT. Pesona Citra Propertindo',
                'tanggal_dimulai_proyek' => '2023-09-30',
                'tanggal_selesai_proyek' => '2024-02-01',
                'kategori' => 'jalan',
                'nilai_kontrak' => 229253024,
                'deskripsi' => "Pekerjaan Pengadaan dan Pemasangan Track Gondola Rooftop Proyek CBI Office Pangkalan Bun\r\n"
            ],
            [
                'name' => 'Project Transmart Cirebon',
                'pemberi_kerja' => 'PT. Pembangunan Perumahan (Persero) Tbk',
                'tanggal_dimulai_proyek' => '2017-06-16',
                'tanggal_selesai_proyek' => '2017-12-18',
                'kategori' => 'gedung',
                'nilai_kontrak' => 2361700000,
                'deskripsi' => "Pekerjaan ACP Transmart Cirebon\r\n"
            ],
            [
                'name' => 'Project Yayasan',
                'pemberi_kerja' => 'Yayasan Masjid Agung Baitunnur Blora',
                'tanggal_dimulai_proyek' => '2022-01-25',
                'tanggal_selesai_proyek' => '2022-03-02',
                'kategori' => 'other',
                'nilai_kontrak' => 130600000,
                'deskripsi' => "Proyek Yayasan Masjid Agung Baitunnur Blora - Pengadaan Ranjang 2 Susun Tahap I dan II\r\n"
            ],
            [
                'name' => 'Project AEON Mixed Use Sentul City',
                'pemberi_kerja' => 'PT. Pembangunan Perumahan (Persero) Tbk',
                'tanggal_dimulai_proyek' => '2021-03-08',
                'tanggal_selesai_proyek' => '2021-04-07',
                'kategori' => 'other',
                'nilai_kontrak' => 1005934404,
                'deskripsi' => "Pekerjaan plafond apartemen AEON Lt. 4 - Lt. 15\r\n"
            ],
            [
                'name' => 'Project APMS Soekarno Hatta',
                'pemberi_kerja' => 'Wijaya Indulexco',
                'tanggal_dimulai_proyek' => '2017-08-26',
                'tanggal_selesai_proyek' => '2017-11-28',
                'kategori' => 'gedung',
                'nilai_kontrak' => 3436527325,
                'deskripsi' => "Pekerjaan Pengadaan dan Pemasangan plafond metal Terminal 1 Bandara Soekarno Hatta\r\n"
            ],
            [
                'name' => 'Project BW Express',
                'pemberi_kerja' => 'PT. Tetragraha Konstruksindo',
                'tanggal_dimulai_proyek' => '2023-12-29',
                'tanggal_selesai_proyek' => '2024-02-28',
                'kategori' => 'other',
                'nilai_kontrak' => 416165918,
                'deskripsi' => "Plafond Canopy PVC Board\r\n"
            ],
            [
                'name' => 'Project BW Express',
                'pemberi_kerja' => 'PT. Tetragraha Konstruksindo',
                'tanggal_dimulai_proyek' => '2023-12-29',
                'tanggal_selesai_proyek' => '2024-02-28',
                'kategori' => 'other',
                'nilai_kontrak' => 416165918,
                'deskripsi' => " Plafond Canopy WPC Duma\r\n"
            ],
            [
                'name' => 'Project Mercure Hotel CBI Office',
                'pemberi_kerja' => 'PT. Pesona Citra Propertindo',
                'tanggal_dimulai_proyek' => '2023-01-23',
                'tanggal_selesai_proyek' => '2023-03-22',
                'kategori' => 'other',
                'nilai_kontrak' => 1943916855,
                'deskripsi' => "Pengadaan dan Pemasangan Batu Andesit\r\n"
            ],
            [
                'name' => 'Project Mercure Hotel CBI Office',
                'pemberi_kerja' => 'PT. Pesona Citra Propertindo',
                'tanggal_dimulai_proyek' => '2024-06-11',
                'tanggal_selesai_proyek' => '2024-08-10',
                'kategori' => 'gedung',
                'nilai_kontrak' => 138750000,
                'deskripsi' => "Pek. ATM Center\r\n"
            ],
            [
                'name' => 'Project Mercure Hotel CBI Office',
                'pemberi_kerja' => 'PT. Pesona Citra Propertindo',
                'tanggal_dimulai_proyek' => '2024-08-12',
                'tanggal_selesai_proyek' => '2024-10-11',
                'kategori' => 'rumah',
                'nilai_kontrak' => 321968842,
                'deskripsi' => "Pek. Variation  Order Struktur & Arsitektur\r\n"
            ],
            [
                'name' => 'Project AKA-OFF',
                'pemberi_kerja' => 'PT. Adhidaya Ciptakharisma',
                'tanggal_dimulai_proyek' => '2022-08-30',
                'tanggal_selesai_proyek' => '2022-10-28',
                'kategori' => 'other',
                'nilai_kontrak' => 85723954,
                'deskripsi' => "Pekerjaan Partisi Gypsum 9mm Rangka 2 Sisi Bangunan Office untuk Proyek Asmara Karya Abadi - Sentul\r\n"
            ],
            [
                'name' => 'Project Perumahan G6 Permanen Bravo',
                'pemberi_kerja' => 'PT. Karyatama Unggul Sejahtera',
                'tanggal_dimulai_proyek' => '2024-10-04',
                'tanggal_selesai_proyek' => '2025-06-10',
                'kategori' => 'rumah',
                'nilai_kontrak' => 1143300000,
                'deskripsi' => "Pembangunan Perumahan G-6 Permanen PT Tanjung Sawit Abadi\r\n"
            ],
        ];

        foreach ($projects as $project) {
            // -- LOGIKA PENAMBAHAN STATUS DIMULAI DI SINI --

            // 1. Cek jika 'tanggal_selesai_proyek' ada dan nilainya bukan '0001-01-01'.
            //    Ini untuk menangani kasus dimana tanggalnya belum di-set.
            if (isset($project['tanggal_selesai_proyek']) && $project['tanggal_selesai_proyek'] !== '0001-01-01') {
                $status = 'Selesai';
            } else {
                $status = 'On Progress';
            }

            // 2. Tambahkan key 'status' ke dalam array project saat ini.
            $project['status'] = $status;

            // -- LOGIKA PENAMBAHAN STATUS SELESAI --

            // 3. Lanjutkan proses update atau create dengan data project yang sudah dimodifikasi.
            //    Array $project sekarang sudah berisi key 'status' dengan nilai yang benar.
            Project::updateOrCreate(
                ['name' => $project['name']], // syarat pencarian
                $project                       // data yang diupdate/dibuat
            );
        }
    }
}
