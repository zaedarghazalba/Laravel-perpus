<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $ebooks = [
            // Fiksi
            [
                'title' => 'Cantik Itu Luka',
                'author' => 'Eka Kurniawan',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9786020331775',
                'publication_year' => 2015,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'description' => 'Novel magis realis yang mengisahkan kehidupan Dewi Ayu dan keluarganya di Indonesia.',
                'file_path' => 'uploads/ebooks/cantik-itu-luka.pdf',
                'is_published' => true,
                'view_count' => 245,
                'download_count' => 89,
            ],
            [
                'title' => 'Pulang',
                'author' => 'Leila S. Chudori',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '9786024246563',
                'publication_year' => 2012,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'description' => 'Novel tentang para eksil politik Indonesia di Paris dan kehidupan mereka.',
                'file_path' => 'uploads/ebooks/pulang.pdf',
                'is_published' => true,
                'view_count' => 178,
                'download_count' => 65,
            ],

            // Non-Fiksi
            [
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '9786024553906',
                'publication_year' => 2017,
                'category_id' => $categories['non-fiksi']->id,
                'classification_code' => '930',
                'description' => 'Sejarah umat manusia dari zaman batu hingga era modern.',
                'file_path' => 'uploads/ebooks/sapiens.pdf',
                'is_published' => true,
                'view_count' => 523,
                'download_count' => 234,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9786020633176',
                'publication_year' => 2019,
                'category_id' => $categories['non-fiksi']->id,
                'classification_code' => '158.1',
                'description' => 'Cara mudah dan terbukti untuk membentuk kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'file_path' => 'uploads/ebooks/atomic-habits.pdf',
                'is_published' => true,
                'view_count' => 412,
                'download_count' => 198,
            ],

            // Komputer & Teknologi
            [
                'title' => 'Pemrograman Python untuk Pemula',
                'author' => 'Budi Raharjo',
                'publisher' => 'Informatika',
                'isbn' => '9786025884234',
                'publication_year' => 2020,
                'category_id' => $categories['komputer-teknologi']->id,
                'classification_code' => '005.133',
                'description' => 'Panduan lengkap belajar Python dari dasar hingga mahir.',
                'file_path' => 'uploads/ebooks/python-pemula.pdf',
                'is_published' => true,
                'view_count' => 689,
                'download_count' => 312,
            ],
            [
                'title' => 'Machine Learning Praktis',
                'author' => 'Andrew Ng',
                'publisher' => 'Andi Publisher',
                'isbn' => '9789792956789',
                'publication_year' => 2021,
                'category_id' => $categories['komputer-teknologi']->id,
                'classification_code' => '006.31',
                'description' => 'Implementasi praktis algoritma machine learning dengan Python.',
                'file_path' => 'uploads/ebooks/machine-learning.pdf',
                'is_published' => true,
                'view_count' => 456,
                'download_count' => 203,
            ],
            [
                'title' => 'Web Development dengan Laravel',
                'author' => 'Imam Nurhadi',
                'publisher' => 'Elex Media Komputindo',
                'isbn' => '9786230020567',
                'publication_year' => 2023,
                'category_id' => $categories['komputer-teknologi']->id,
                'classification_code' => '005.133',
                'description' => 'Panduan lengkap membangun aplikasi web modern dengan Laravel framework.',
                'file_path' => 'uploads/ebooks/laravel-web-dev.pdf',
                'is_published' => false,
                'view_count' => 123,
                'download_count' => 45,
            ],

            // Sains
            [
                'title' => 'Kosmos: Sejarah Alam Semesta',
                'author' => 'Carl Sagan',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '9786024553234',
                'publication_year' => 2018,
                'category_id' => $categories['sains']->id,
                'classification_code' => '520',
                'description' => 'Petualangan ilmiah menjelajahi alam semesta dan tempat kita di dalamnya.',
                'file_path' => 'uploads/ebooks/kosmos.pdf',
                'is_published' => true,
                'view_count' => 267,
                'download_count' => 112,
            ],

            // Sejarah
            [
                'title' => 'Indonesia dalam Arus Sejarah Jilid 1',
                'author' => 'Tim Penulis',
                'publisher' => 'Ichtiar Baru van Hoeve',
                'isbn' => '9789797991111',
                'publication_year' => 2012,
                'category_id' => $categories['sejarah']->id,
                'classification_code' => '959.8',
                'description' => 'Sejarah Indonesia dari masa prasejarah hingga kerajaan-kerajaan awal.',
                'file_path' => 'uploads/ebooks/sejarah-indonesia-1.pdf',
                'is_published' => true,
                'view_count' => 345,
                'download_count' => 156,
            ],
            [
                'title' => 'Peradaban Islam di Indonesia',
                'author' => 'Azyumardi Azra',
                'publisher' => 'Logos Wacana Ilmu',
                'isbn' => '9789797991889',
                'publication_year' => 2016,
                'category_id' => $categories['sejarah']->id,
                'classification_code' => '297.09',
                'description' => 'Perkembangan Islam dan peradabannya di Nusantara.',
                'file_path' => 'uploads/ebooks/peradaban-islam.pdf',
                'is_published' => true,
                'view_count' => 198,
                'download_count' => 87,
            ],

            // Biografi
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9786022911234',
                'publication_year' => 2015,
                'category_id' => $categories['biografi']->id,
                'classification_code' => '92',
                'description' => 'Biografi resmi pendiri Apple Inc. yang visioner.',
                'file_path' => 'uploads/ebooks/steve-jobs.pdf',
                'is_published' => true,
                'view_count' => 432,
                'download_count' => 201,
            ],

            // Referensi
            [
                'title' => 'Ensiklopedia Sains untuk Pelajar',
                'author' => 'Tim Penyusun',
                'publisher' => 'Erlangga',
                'isbn' => '9789790274567',
                'publication_year' => 2019,
                'category_id' => $categories['referensi']->id,
                'classification_code' => '503',
                'description' => 'Referensi lengkap sains untuk pelajar SMP dan SMA.',
                'file_path' => 'uploads/ebooks/ensiklopedia-sains.pdf',
                'is_published' => true,
                'view_count' => 289,
                'download_count' => 134,
            ],

            // Agama
            [
                'title' => 'Membumikan Al-Quran',
                'author' => 'M. Quraish Shihab',
                'publisher' => 'Lentera Hati',
                'isbn' => '9789797571111',
                'publication_year' => 2007,
                'category_id' => $categories['agama']->id,
                'classification_code' => '297.1',
                'description' => 'Fungsi dan peran wahyu dalam kehidupan masyarakat.',
                'file_path' => 'uploads/ebooks/membumikan-quran.pdf',
                'is_published' => true,
                'view_count' => 312,
                'download_count' => 145,
            ],
            [
                'title' => 'Hidup Berkah dengan Sedekah',
                'author' => 'Ust. Yusuf Mansur',
                'publisher' => 'Zikrul Hakim',
                'isbn' => '9786025551234',
                'publication_year' => 2018,
                'category_id' => $categories['agama']->id,
                'classification_code' => '297.5',
                'description' => 'Keutamaan dan hikmah bersedekah dalam Islam.',
                'file_path' => 'uploads/ebooks/sedekah.pdf',
                'is_published' => false,
                'view_count' => 78,
                'download_count' => 23,
            ],
        ];

        foreach ($ebooks as $ebook) {
            Ebook::create($ebook);
        }
    }
}
