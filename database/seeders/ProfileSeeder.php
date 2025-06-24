<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'headline'             => [
                'Perfection Is Our Priority.',
                'Kami fokus untuk anda.',
                'Interior Design'
            ],
            'main_description'     => 'Desain kontemporer house dalam perencanaan bangunan.',
            'recent_project_desc'  => 'Baru-baru ini kami menyelesaikan sistem ERP untuk perusahaan manufaktur skala nasional. Dalam dunia Arsitektur, warnapun berperan penting.',
            'about_desc'           => 'Merupakan perusahaan swasta nasional yang bergerak di Bidang Usaha Jasa Konstruksi Umum, Perdagangan, Perawatan dan Perbaikan. Didirikan pada Mei 2017.

Pengalaman dalam berbagai proyek yang beraneka ragam dan keberhasilan kami dalam mengatasi segala tantangan adalah berkat inovasi dan kerja tim yang kuat. Kami menekankan koordinasi, kedisiplinan, dan integritas tinggi dalam setiap proyek yang kami kerjakan.',
            'visi' => 'Menjadi Perusahaan Jasa Konstruksi dengan kualifikasi dan kompetensi yang handal serta berorientasi bisnis secara professional.

Meningkatkan, mengembangkan kemampuan dalam bidang konstruksi untuk memenuhi kebutuhan dan bermanfaat bagi masyarakat pengguna.',
            'misi' => 'Menciptakan lapangan kerja berkualitas, dan menjadi sebuah perusahaan jasa yang mengutamakan kepuasan pelanggan untuk menjamin tumbuhnya kepercayaan dan menjadi mitra terdepan.

Membangun Bisnis dan Aset Produktif secara terintegrasi guna memberikan Manfaat & Pelayanan yang Luas Kepada, Masyarakat, Bangsa dan Negara.',
            'nama_kantor'          => 'Jl. Kresna 1, Blok B – 2, No. 17, Bantarjati Kota Bogor – Jawa Barat',
            'nomor_hp'             => '+62 821-1600-0463',
            'email'                => 'murgungnusaparama@gmail.com',
            'website_url'          => 'https://murgung.id',
            'facebook'             => 'https://web.facebook.com/murgung.id',
            'instagram'            => 'https://www.instagram.com/murgungindonesia/',
        ]);
    }
}
