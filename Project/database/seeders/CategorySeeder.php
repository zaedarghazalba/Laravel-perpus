<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku-buku fiksi dan novel'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku-buku non-fiksi dan faktual'],
            ['name' => 'Referensi', 'description' => 'Buku referensi, kamus, ensiklopedia'],
            ['name' => 'Komputer & Teknologi', 'description' => 'Buku tentang komputer, pemrograman, dan teknologi'],
            ['name' => 'Sains', 'description' => 'Buku sains dan ilmu pengetahuan'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah dan peristiwa masa lalu'],
            ['name' => 'Agama', 'description' => 'Buku agama dan spiritual'],
            ['name' => 'Biografi', 'description' => 'Biografi dan autobiografi tokoh terkenal'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
