<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'headline'             => 'Make Your Dream House Come True.',
            'main_description'     => 'Kami menyediakan layanan pengembangan perangkat lunak dan solusi teknologi yang inovatif untuk membantu bisnis Anda berkembang.',
            'recent_project_desc'  => 'Baru-baru ini kami menyelesaikan sistem ERP untuk perusahaan manufaktur skala nasional.',
            'about_desc'           => 'Kami adalah tim pengembang berpengalaman yang berfokus pada kualitas, inovasi, dan kepuasan klien.',
            'nama_kantor'          => 'PT. MURGUNG',
            'nomor_hp'             => '081234567890',
            'email'                => 'murgung@constmg.id',
            'website_url'          => 'https://constmg.id',
        ]);
    }
}
