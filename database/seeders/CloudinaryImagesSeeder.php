<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\CloudinaryImage;
use App\Models\Project;

class CloudinaryImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $cloudName = env('CLOUDINARY_CLOUD_NAME');

        $baseUrl = "https://api.cloudinary.com/v1_1/$cloudName/resources/image?type=upload&max_results=100";
        $nextCursor = null;

        do {
            $url = $baseUrl;
            if ($nextCursor) {
                $url .= "&next_cursor=$nextCursor";
            }

            $response = Http::withBasicAuth($apiKey, $apiSecret)->get($url);

            if (!$response->successful()) {
                $this->command->error('Gagal mengambil data dari Cloudinary');
                return;
            }

            $data = $response->json();

            foreach ($data['resources'] as $item) {
                $assetFolder = $item['asset_folder'] ?? null;
                $projectName = $assetFolder ? basename($assetFolder) : 'Uncategorized';

                // Cari atau buat project berdasarkan nama folder
                $project = Project::firstOrCreate(['name' => $projectName]);

                CloudinaryImage::updateOrCreate(
                    ['asset_id' => $item['asset_id']],
                    [
                        'public_id'     => $item['public_id'],
                        'asset_folder'  => $assetFolder,
                        'display_name'  => $item['display_name'] ?? null,
                        'url'           => $item['url'],
                        'secure_url'    => $item['secure_url'],
                        'project_id'    => $project->id,
                    ]
                );
            }

            $nextCursor = $data['next_cursor'] ?? null;
        } while ($nextCursor);

        $this->command->info('Semua data berhasil disimpan ke database');
    }
}
