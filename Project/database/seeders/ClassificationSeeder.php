<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Dewey Decimal Classification (DDC) System
     */
    public function run(): void
    {
        $classifications = [
            // 000 - Computer science, information & general works
            ['code' => '000', 'name' => 'Ilmu Komputer, Informasi & Karya Umum', 'description' => 'Computer science, information & general works', 'parent_code' => null, 'level' => 1],
            ['code' => '001', 'name' => 'Pengetahuan', 'description' => 'Knowledge', 'parent_code' => '000', 'level' => 2],
            ['code' => '004', 'name' => 'Pemrosesan Data & Ilmu Komputer', 'description' => 'Data processing & computer science', 'parent_code' => '000', 'level' => 2],
            ['code' => '005', 'name' => 'Pemrograman Komputer', 'description' => 'Computer programming', 'parent_code' => '004', 'level' => 3],
            ['code' => '005.1', 'name' => 'Algoritma & Struktur Data', 'description' => 'Algorithms & Data structures', 'parent_code' => '005', 'level' => 4],
            ['code' => '005.133', 'name' => 'Bahasa Pemrograman Khusus', 'description' => 'Specific programming languages', 'parent_code' => '005', 'level' => 4],
            ['code' => '006', 'name' => 'Metode Komputasi Khusus', 'description' => 'Special computer methods', 'parent_code' => '004', 'level' => 3],
            ['code' => '006.3', 'name' => 'Kecerdasan Buatan', 'description' => 'Artificial intelligence', 'parent_code' => '006', 'level' => 4],
            ['code' => '006.31', 'name' => 'Machine Learning', 'description' => 'Machine learning', 'parent_code' => '006.3', 'level' => 5],
            ['code' => '010', 'name' => 'Bibliografi', 'description' => 'Bibliography', 'parent_code' => '000', 'level' => 2],
            ['code' => '020', 'name' => 'Ilmu Perpustakaan & Informasi', 'description' => 'Library & information sciences', 'parent_code' => '000', 'level' => 2],
            ['code' => '030', 'name' => 'Ensiklopedia Umum', 'description' => 'General encyclopedias', 'parent_code' => '000', 'level' => 2],
            ['code' => '070', 'name' => 'Media Berita & Jurnalisme', 'description' => 'News media & journalism', 'parent_code' => '000', 'level' => 2],
            ['code' => '080', 'name' => 'Koleksi Umum', 'description' => 'General collections', 'parent_code' => '000', 'level' => 2],

            // 100 - Philosophy & psychology
            ['code' => '100', 'name' => 'Filsafat & Psikologi', 'description' => 'Philosophy & psychology', 'parent_code' => null, 'level' => 1],
            ['code' => '110', 'name' => 'Metafisika', 'description' => 'Metaphysics', 'parent_code' => '100', 'level' => 2],
            ['code' => '120', 'name' => 'Epistemologi', 'description' => 'Epistemology', 'parent_code' => '100', 'level' => 2],
            ['code' => '130', 'name' => 'Fenomena Paranormal', 'description' => 'Paranormal phenomena', 'parent_code' => '100', 'level' => 2],
            ['code' => '140', 'name' => 'Aliran Filsafat', 'description' => 'Philosophical schools', 'parent_code' => '100', 'level' => 2],
            ['code' => '150', 'name' => 'Psikologi', 'description' => 'Psychology', 'parent_code' => '100', 'level' => 2],
            ['code' => '158.1', 'name' => 'Pengembangan Diri & Kebiasaan', 'description' => 'Self-improvement & Habits', 'parent_code' => '150', 'level' => 3],
            ['code' => '160', 'name' => 'Logika', 'description' => 'Logic', 'parent_code' => '100', 'level' => 2],
            ['code' => '170', 'name' => 'Etika', 'description' => 'Ethics', 'parent_code' => '100', 'level' => 2],
            ['code' => '180', 'name' => 'Filsafat Kuno', 'description' => 'Ancient philosophy', 'parent_code' => '100', 'level' => 2],
            ['code' => '188', 'name' => 'Filsafat Stoikisme', 'description' => 'Stoic philosophy', 'parent_code' => '180', 'level' => 3],
            ['code' => '190', 'name' => 'Filsafat Modern', 'description' => 'Modern philosophy', 'parent_code' => '100', 'level' => 2],

            // 200 - Religion
            ['code' => '200', 'name' => 'Agama', 'description' => 'Religion', 'parent_code' => null, 'level' => 1],
            ['code' => '210', 'name' => 'Teologi Natural', 'description' => 'Natural theology', 'parent_code' => '200', 'level' => 2],
            ['code' => '220', 'name' => 'Alkitab', 'description' => 'Bible', 'parent_code' => '200', 'level' => 2],
            ['code' => '230', 'name' => 'Teologi Kristen', 'description' => 'Christian theology', 'parent_code' => '200', 'level' => 2],
            ['code' => '290', 'name' => 'Agama Lain', 'description' => 'Other religions', 'parent_code' => '200', 'level' => 2],
            ['code' => '297', 'name' => 'Islam', 'description' => 'Islam', 'parent_code' => '290', 'level' => 3],
            ['code' => '297.1', 'name' => 'Al-Quran & Tafsir', 'description' => 'Quran & Tafsir', 'parent_code' => '297', 'level' => 4],
            ['code' => '297.3', 'name' => 'Fiqih & Hukum Islam', 'description' => 'Islamic jurisprudence', 'parent_code' => '297', 'level' => 4],
            ['code' => '297.5', 'name' => 'Ibadah & Praktik Islam', 'description' => 'Islamic worship & practices', 'parent_code' => '297', 'level' => 4],
            ['code' => '297.09', 'name' => 'Sejarah Islam', 'description' => 'Islamic history', 'parent_code' => '297', 'level' => 4],
            ['code' => '294', 'name' => 'Buddha & Hindu', 'description' => 'Buddhism & Hinduism', 'parent_code' => '290', 'level' => 3],

            // 300 - Social sciences
            ['code' => '300', 'name' => 'Ilmu Sosial', 'description' => 'Social sciences', 'parent_code' => null, 'level' => 1],
            ['code' => '310', 'name' => 'Statistik', 'description' => 'Statistics', 'parent_code' => '300', 'level' => 2],
            ['code' => '320', 'name' => 'Ilmu Politik', 'description' => 'Political science', 'parent_code' => '300', 'level' => 2],
            ['code' => '330', 'name' => 'Ekonomi', 'description' => 'Economics', 'parent_code' => '300', 'level' => 2],
            ['code' => '340', 'name' => 'Hukum', 'description' => 'Law', 'parent_code' => '300', 'level' => 2],
            ['code' => '350', 'name' => 'Administrasi Publik', 'description' => 'Public administration', 'parent_code' => '300', 'level' => 2],
            ['code' => '360', 'name' => 'Masalah & Layanan Sosial', 'description' => 'Social problems & services', 'parent_code' => '300', 'level' => 2],
            ['code' => '370', 'name' => 'Pendidikan', 'description' => 'Education', 'parent_code' => '300', 'level' => 2],
            ['code' => '380', 'name' => 'Perdagangan', 'description' => 'Commerce', 'parent_code' => '300', 'level' => 2],
            ['code' => '390', 'name' => 'Adat Istiadat & Kebudayaan', 'description' => 'Customs & culture', 'parent_code' => '300', 'level' => 2],
            ['code' => '398', 'name' => 'Cerita Rakyat & Legenda', 'description' => 'Folklore & legends', 'parent_code' => '390', 'level' => 3],
            ['code' => '398.2', 'name' => 'Dongeng & Cerita Rakyat', 'description' => 'Folk tales & fairy tales', 'parent_code' => '398', 'level' => 4],

            // 400 - Language
            ['code' => '400', 'name' => 'Bahasa', 'description' => 'Language', 'parent_code' => null, 'level' => 1],
            ['code' => '410', 'name' => 'Linguistik', 'description' => 'Linguistics', 'parent_code' => '400', 'level' => 2],
            ['code' => '420', 'name' => 'Bahasa Inggris', 'description' => 'English language', 'parent_code' => '400', 'level' => 2],
            ['code' => '430', 'name' => 'Bahasa Jerman', 'description' => 'German language', 'parent_code' => '400', 'level' => 2],
            ['code' => '440', 'name' => 'Bahasa Prancis', 'description' => 'French language', 'parent_code' => '400', 'level' => 2],
            ['code' => '450', 'name' => 'Bahasa Italia', 'description' => 'Italian language', 'parent_code' => '400', 'level' => 2],
            ['code' => '460', 'name' => 'Bahasa Spanyol', 'description' => 'Spanish language', 'parent_code' => '400', 'level' => 2],
            ['code' => '490', 'name' => 'Bahasa Lainnya', 'description' => 'Other languages', 'parent_code' => '400', 'level' => 2],
            ['code' => '499', 'name' => 'Bahasa Indonesia & Melayu', 'description' => 'Indonesian & Malay language', 'parent_code' => '490', 'level' => 3],
            ['code' => '499.221', 'name' => 'Kamus Bahasa Indonesia', 'description' => 'Indonesian dictionary', 'parent_code' => '499', 'level' => 4],

            // 500 - Science
            ['code' => '500', 'name' => 'Sains', 'description' => 'Science', 'parent_code' => null, 'level' => 1],
            ['code' => '503', 'name' => 'Ensiklopedia & Kamus Sains', 'description' => 'Science encyclopedias & dictionaries', 'parent_code' => '500', 'level' => 2],
            ['code' => '510', 'name' => 'Matematika', 'description' => 'Mathematics', 'parent_code' => '500', 'level' => 2],
            ['code' => '520', 'name' => 'Astronomi & Kosmologi', 'description' => 'Astronomy & cosmology', 'parent_code' => '500', 'level' => 2],
            ['code' => '530', 'name' => 'Fisika', 'description' => 'Physics', 'parent_code' => '500', 'level' => 2],
            ['code' => '540', 'name' => 'Kimia', 'description' => 'Chemistry', 'parent_code' => '500', 'level' => 2],
            ['code' => '550', 'name' => 'Ilmu Bumi', 'description' => 'Earth sciences', 'parent_code' => '500', 'level' => 2],
            ['code' => '560', 'name' => 'Paleontologi', 'description' => 'Paleontology', 'parent_code' => '500', 'level' => 2],
            ['code' => '570', 'name' => 'Biologi', 'description' => 'Biology', 'parent_code' => '500', 'level' => 2],
            ['code' => '580', 'name' => 'Botani', 'description' => 'Botany', 'parent_code' => '500', 'level' => 2],
            ['code' => '590', 'name' => 'Zoologi', 'description' => 'Zoology', 'parent_code' => '500', 'level' => 2],

            // 600 - Technology
            ['code' => '600', 'name' => 'Teknologi', 'description' => 'Technology', 'parent_code' => null, 'level' => 1],
            ['code' => '610', 'name' => 'Kedokteran & Kesehatan', 'description' => 'Medicine & health', 'parent_code' => '600', 'level' => 2],
            ['code' => '620', 'name' => 'Teknik & Operasi Terapan', 'description' => 'Engineering', 'parent_code' => '600', 'level' => 2],
            ['code' => '630', 'name' => 'Pertanian', 'description' => 'Agriculture', 'parent_code' => '600', 'level' => 2],
            ['code' => '640', 'name' => 'Ekonomi Rumah Tangga', 'description' => 'Home economics', 'parent_code' => '600', 'level' => 2],
            ['code' => '650', 'name' => 'Manajemen & Bisnis', 'description' => 'Management & business', 'parent_code' => '600', 'level' => 2],
            ['code' => '660', 'name' => 'Teknik Kimia', 'description' => 'Chemical engineering', 'parent_code' => '600', 'level' => 2],
            ['code' => '670', 'name' => 'Manufaktur', 'description' => 'Manufacturing', 'parent_code' => '600', 'level' => 2],
            ['code' => '680', 'name' => 'Manufaktur Produk Khusus', 'description' => 'Manufacture of specific products', 'parent_code' => '600', 'level' => 2],
            ['code' => '690', 'name' => 'Bangunan', 'description' => 'Buildings', 'parent_code' => '600', 'level' => 2],

            // 700 - Arts & recreation
            ['code' => '700', 'name' => 'Seni & Rekreasi', 'description' => 'Arts & recreation', 'parent_code' => null, 'level' => 1],
            ['code' => '710', 'name' => 'Tata Kota & Lanskap', 'description' => 'Civic & landscape art', 'parent_code' => '700', 'level' => 2],
            ['code' => '720', 'name' => 'Arsitektur', 'description' => 'Architecture', 'parent_code' => '700', 'level' => 2],
            ['code' => '730', 'name' => 'Seni Pahat', 'description' => 'Sculpture', 'parent_code' => '700', 'level' => 2],
            ['code' => '740', 'name' => 'Menggambar & Seni Dekoratif', 'description' => 'Drawing & decorative arts', 'parent_code' => '700', 'level' => 2],
            ['code' => '741.5', 'name' => 'Komik & Novel Grafis', 'description' => 'Comics & graphic novels', 'parent_code' => '740', 'level' => 3],
            ['code' => '750', 'name' => 'Seni Lukis', 'description' => 'Painting', 'parent_code' => '700', 'level' => 2],
            ['code' => '760', 'name' => 'Seni Grafis', 'description' => 'Graphic arts', 'parent_code' => '700', 'level' => 2],
            ['code' => '770', 'name' => 'Fotografi', 'description' => 'Photography', 'parent_code' => '700', 'level' => 2],
            ['code' => '780', 'name' => 'Musik', 'description' => 'Music', 'parent_code' => '700', 'level' => 2],
            ['code' => '790', 'name' => 'Olahraga & Hiburan', 'description' => 'Sports & recreation', 'parent_code' => '700', 'level' => 2],

            // 800 - Literature
            ['code' => '800', 'name' => 'Sastra', 'description' => 'Literature', 'parent_code' => null, 'level' => 1],
            ['code' => '810', 'name' => 'Sastra Amerika', 'description' => 'American literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '820', 'name' => 'Sastra Inggris', 'description' => 'English literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '830', 'name' => 'Sastra Jerman', 'description' => 'German literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '840', 'name' => 'Sastra Prancis', 'description' => 'French literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '850', 'name' => 'Sastra Italia', 'description' => 'Italian literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '860', 'name' => 'Sastra Spanyol', 'description' => 'Spanish literature', 'parent_code' => '800', 'level' => 2],
            ['code' => '890', 'name' => 'Sastra Lainnya', 'description' => 'Other literatures', 'parent_code' => '800', 'level' => 2],
            ['code' => '899', 'name' => 'Sastra Indonesia', 'description' => 'Indonesian literature', 'parent_code' => '890', 'level' => 3],
            ['code' => '899.221', 'name' => 'Fiksi Indonesia', 'description' => 'Indonesian fiction', 'parent_code' => '899', 'level' => 4],

            // 900 - History & geography
            ['code' => '900', 'name' => 'Sejarah & Geografi', 'description' => 'History & geography', 'parent_code' => null, 'level' => 1],
            ['code' => '910', 'name' => 'Geografi & Perjalanan', 'description' => 'Geography & travel', 'parent_code' => '900', 'level' => 2],
            ['code' => '920', 'name' => 'Biografi', 'description' => 'Biography', 'parent_code' => '900', 'level' => 2],
            ['code' => '92', 'name' => 'Biografi Individual', 'description' => 'Individual biography', 'parent_code' => '920', 'level' => 3],
            ['code' => '930', 'name' => 'Sejarah Dunia Kuno & Sejarah Manusia', 'description' => 'Ancient world & human history', 'parent_code' => '900', 'level' => 2],
            ['code' => '940', 'name' => 'Sejarah Eropa', 'description' => 'European history', 'parent_code' => '900', 'level' => 2],
            ['code' => '950', 'name' => 'Sejarah Asia', 'description' => 'Asian history', 'parent_code' => '900', 'level' => 2],
            ['code' => '959', 'name' => 'Sejarah Asia Tenggara', 'description' => 'Southeast Asian history', 'parent_code' => '950', 'level' => 3],
            ['code' => '959.8', 'name' => 'Sejarah Indonesia', 'description' => 'Indonesian history', 'parent_code' => '959', 'level' => 4],
            ['code' => '960', 'name' => 'Sejarah Afrika', 'description' => 'African history', 'parent_code' => '900', 'level' => 2],
            ['code' => '970', 'name' => 'Sejarah Amerika Utara', 'description' => 'North American history', 'parent_code' => '900', 'level' => 2],
            ['code' => '980', 'name' => 'Sejarah Amerika Selatan', 'description' => 'South American history', 'parent_code' => '900', 'level' => 2],
            ['code' => '990', 'name' => 'Sejarah Wilayah Lain', 'description' => 'History of other areas', 'parent_code' => '900', 'level' => 2],
        ];

        foreach ($classifications as $classification) {
            Classification::create($classification);
        }
    }
}
