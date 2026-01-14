<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $books = [
            // Fiksi / Novel Indonesia
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9789793062792',
                'barcode' => 'BC001',
                'publication_year' => 2005,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'call_number' => '899.221 HIR l',
                'quantity' => 5,
                'available_quantity' => 5,
                'description' => 'Novel yang mengisahkan kehidupan 10 anak dari keluarga miskin yang bersekolah di SD Muhammadiyah di Belitung.',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'isbn' => '9789799731234',
                'barcode' => 'BC002',
                'publication_year' => 1980,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'call_number' => '899.221 TOE b',
                'quantity' => 3,
                'available_quantity' => 3,
                'description' => 'Novel pertama dari Tetralogi Buru yang mengisahkan kehidupan Minke, seorang pribumi di era kolonial Belanda.',
            ],
            [
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9789792202335',
                'barcode' => 'BC003',
                'publication_year' => 1982,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'call_number' => '899.221 TOH r',
                'quantity' => 4,
                'available_quantity' => 4,
                'description' => 'Novel tentang kehidupan Srintil, seorang penari ronggeng di sebuah desa kecil di Jawa Tengah.',
            ],
            [
                'title' => 'Perahu Kertas',
                'author' => 'Dee Lestari',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9786021780015',
                'barcode' => 'BC004',
                'publication_year' => 2009,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '899.221',
                'call_number' => '899.221 LES p',
                'quantity' => 6,
                'available_quantity' => 6,
                'description' => 'Novel romantis tentang Kugy dan Keenan yang mengejar impian mereka masing-masing.',
            ],

            // Non-Fiksi / Filsafat
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Kompas Gramedia',
                'isbn' => '9786024553609',
                'barcode' => 'BC005',
                'publication_year' => 2018,
                'category_id' => $categories['non-fiksi']->id,
                'classification_code' => '188',
                'call_number' => '188 MAN f',
                'quantity' => 8,
                'available_quantity' => 8,
                'description' => 'Buku tentang filosofi Stoikisme dan penerapannya dalam kehidupan sehari-hari.',
            ],

            // Komputer & Teknologi
            [
                'title' => 'Algoritma dan Struktur Data',
                'author' => 'Rinaldi Munir',
                'publisher' => 'Informatika',
                'isbn' => '9789797091234',
                'barcode' => 'BC006',
                'publication_year' => 2019,
                'category_id' => $categories['komputer-teknologi']->id,
                'classification_code' => '005.1',
                'call_number' => '005.1 MUN a',
                'quantity' => 10,
                'available_quantity' => 10,
                'description' => 'Buku tentang konsep algoritma dan struktur data untuk mahasiswa ilmu komputer.',
            ],
            [
                'title' => 'Pengantar Kecerdasan Buatan',
                'author' => 'Stuart Russell & Peter Norvig',
                'publisher' => 'Andi Publisher',
                'isbn' => '9789792918234',
                'barcode' => 'BC007',
                'publication_year' => 2020,
                'category_id' => $categories['komputer-teknologi']->id,
                'classification_code' => '006.3',
                'call_number' => '006.3 RUS p',
                'quantity' => 5,
                'available_quantity' => 5,
                'description' => 'Buku tentang konsep dasar dan penerapan kecerdasan buatan.',
            ],

            // Sains / Fisika
            [
                'title' => 'Fisika untuk Sains dan Teknik',
                'author' => 'Raymond A. Serway',
                'publisher' => 'Salemba Teknika',
                'isbn' => '9786028394567',
                'barcode' => 'BC008',
                'publication_year' => 2018,
                'category_id' => $categories['sains']->id,
                'classification_code' => '530',
                'call_number' => '530 SER f',
                'quantity' => 7,
                'available_quantity' => 7,
                'description' => 'Buku teks fisika untuk mahasiswa sains dan teknik.',
            ],

            // Sejarah Indonesia
            [
                'title' => 'Sejarah Nasional Indonesia',
                'author' => 'Nugroho Notosusanto',
                'publisher' => 'Balai Pustaka',
                'isbn' => '9789794071234',
                'barcode' => 'BC009',
                'publication_year' => 2008,
                'category_id' => $categories['sejarah']->id,
                'classification_code' => '959.8',
                'call_number' => '959.8 NOT s',
                'quantity' => 4,
                'available_quantity' => 4,
                'description' => 'Buku tentang sejarah Indonesia dari masa kerajaan hingga kemerdekaan.',
            ],
            [
                'title' => 'Indonesia dalam Arus Sejarah',
                'author' => 'Tim Penulis',
                'publisher' => 'Ichtiar Baru van Hoeve',
                'isbn' => '9789797991234',
                'barcode' => 'BC010',
                'publication_year' => 2012,
                'category_id' => $categories['sejarah']->id,
                'classification_code' => '959.8',
                'call_number' => '959.8 TIM i',
                'quantity' => 3,
                'available_quantity' => 3,
                'description' => 'Ensiklopedia sejarah Indonesia yang komprehensif dari masa prasejarah hingga modern.',
            ],
            [
                'title' => 'Perang Jawa 1825-1830',
                'author' => 'Peter Carey',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '9789799102345',
                'barcode' => 'BC011',
                'publication_year' => 2012,
                'category_id' => $categories['sejarah']->id,
                'classification_code' => '959.8',
                'call_number' => '959.8 CAR p',
                'quantity' => 3,
                'available_quantity' => 3,
                'description' => 'Penelitian mendalam tentang Perang Diponegoro melawan Belanda.',
            ],

            // Biografi
            [
                'title' => 'Bung Karno: Penyambung Lidah Rakyat',
                'author' => 'Cindy Adams',
                'publisher' => 'Yayasan Bung Karno',
                'isbn' => '9789795114567',
                'barcode' => 'BC012',
                'publication_year' => 1984,
                'category_id' => $categories['biografi']->id,
                'classification_code' => '92',
                'call_number' => '92 ADA b',
                'quantity' => 4,
                'available_quantity' => 4,
                'description' => 'Autobiografi Presiden Soekarno sebagaimana diceritakan kepada Cindy Adams.',
            ],
            [
                'title' => 'Habibie & Ainun',
                'author' => 'Bacharuddin Jusuf Habibie',
                'publisher' => 'THC Mandiri',
                'isbn' => '9786028519878',
                'barcode' => 'BC013',
                'publication_year' => 2010,
                'category_id' => $categories['biografi']->id,
                'classification_code' => '92',
                'call_number' => '92 HAB h',
                'quantity' => 5,
                'available_quantity' => 5,
                'description' => 'Kisah cinta BJ Habibie dan istri tercintanya, Hasri Ainun Besari.',
            ],

            // Referensi
            [
                'title' => 'Kamus Besar Bahasa Indonesia',
                'author' => 'Tim Penyusun KBBI',
                'publisher' => 'Balai Pustaka',
                'isbn' => '9789794074565',
                'barcode' => 'BC014',
                'publication_year' => 2016,
                'category_id' => $categories['referensi']->id,
                'classification_code' => '499.221',
                'call_number' => '499.221 TIM k',
                'quantity' => 6,
                'available_quantity' => 6,
                'description' => 'Kamus resmi bahasa Indonesia yang disusun oleh Badan Pengembangan Bahasa.',
            ],
            [
                'title' => 'Ensiklopedia Indonesia',
                'author' => 'Tim Ensiklopedia',
                'publisher' => 'Ichtiar Baru van Hoeve',
                'isbn' => '9789797991567',
                'barcode' => 'BC015',
                'publication_year' => 2015,
                'category_id' => $categories['referensi']->id,
                'classification_code' => '030',
                'call_number' => '030 TIM e',
                'quantity' => 3,
                'available_quantity' => 3,
                'description' => 'Ensiklopedia lengkap tentang Indonesia mencakup geografi, budaya, sejarah.',
            ],

            // Agama Islam
            [
                'title' => 'Tafsir Al-Misbah',
                'author' => 'M. Quraish Shihab',
                'publisher' => 'Lentera Hati',
                'isbn' => '9789797571234',
                'barcode' => 'BC016',
                'publication_year' => 2002,
                'category_id' => $categories['agama']->id,
                'classification_code' => '297.1',
                'call_number' => '297.1 SHI t',
                'quantity' => 5,
                'available_quantity' => 5,
                'description' => 'Tafsir Al-Quran yang komprehensif dalam bahasa Indonesia.',
            ],
            [
                'title' => 'Fiqih Sunnah',
                'author' => 'Sayyid Sabiq',
                'publisher' => 'Pena Pundi Aksara',
                'isbn' => '9789797682345',
                'barcode' => 'BC017',
                'publication_year' => 2008,
                'category_id' => $categories['agama']->id,
                'classification_code' => '297.3',
                'call_number' => '297.3 SAB f',
                'quantity' => 4,
                'available_quantity' => 4,
                'description' => 'Panduan praktis tentang hukum-hukum Islam dalam kehidupan sehari-hari.',
            ],

            // Buku Anak / Dongeng
            [
                'title' => 'Dongeng-Dongeng Nusantara',
                'author' => 'Murti Bunanta',
                'publisher' => 'Grasindo',
                'isbn' => '9789790335567',
                'barcode' => 'BC018',
                'publication_year' => 2010,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '398.2',
                'call_number' => '398.2 BUN d',
                'quantity' => 8,
                'available_quantity' => 8,
                'description' => 'Kumpulan dongeng tradisional dari berbagai daerah di Indonesia.',
            ],

            // Komik
            [
                'title' => 'Si Juki',
                'author' => 'Faza Meonk',
                'publisher' => 'Bukune',
                'isbn' => '9786027572034',
                'barcode' => 'BC019',
                'publication_year' => 2014,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '741.5',
                'call_number' => '741.5 MEO s',
                'quantity' => 6,
                'available_quantity' => 6,
                'description' => 'Komik humor Indonesia tentang kehidupan sehari-hari Si Juki.',
            ],
            [
                'title' => 'Garudayana',
                'author' => 'Is Yuniarto',
                'publisher' => 'Koloni',
                'isbn' => '9786029499237',
                'barcode' => 'BC020',
                'publication_year' => 2016,
                'category_id' => $categories['fiksi']->id,
                'classification_code' => '741.5',
                'call_number' => '741.5 YUN g',
                'quantity' => 5,
                'available_quantity' => 5,
                'description' => 'Komik superhero Indonesia yang terinspirasi dari mitologi Nusantara.',
            ],
        ];

        foreach ($books as $bookData) {
            // Auto-generate shelf location from classification code
            if (!empty($bookData['classification_code']) && empty($bookData['shelf_location'])) {
                $bookData['shelf_location'] = Book::generateShelfLocation($bookData['classification_code']);
            }

            Book::create($bookData);
        }
    }
}
