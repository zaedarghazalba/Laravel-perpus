<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\EbookView;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EbookViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ebooks = Ebook::where('is_published', true)->get();

        // Sample IP addresses for variety
        $ipAddresses = [
            '192.168.1.1',
            '192.168.1.2',
            '192.168.1.3',
            '192.168.1.4',
            '192.168.1.5',
            '10.0.0.1',
            '10.0.0.2',
            '10.0.0.3',
            '172.16.0.1',
            '172.16.0.2',
        ];

        foreach ($ebooks as $ebook) {
            // Generate random views based on ebook's view_count
            $viewCount = $ebook->view_count ?? 0;

            // Create view records (max 50 per ebook for seed data)
            $recordsToCreate = min($viewCount, 50);

            for ($i = 0; $i < $recordsToCreate; $i++) {
                EbookView::create([
                    'ebook_id' => $ebook->id,
                    'ip_address' => $ipAddresses[array_rand($ipAddresses)],
                    'viewed_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                ]);
            }
        }
    }
}
