<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ahmad Fauzi',
                'student_id' => '2024001',
                'email' => 'ahmad.fauzi@student.ac.id',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'join_date' => Carbon::parse('2024-01-15'),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'student_id' => '2024002',
                'email' => 'siti.nurhaliza@student.ac.id',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 25, Bandung',
                'join_date' => Carbon::parse('2024-01-20'),
            ],
            [
                'name' => 'Budi Santoso',
                'student_id' => '2024003',
                'email' => 'budi.santoso@student.ac.id',
                'phone' => '081234567892',
                'address' => 'Jl. Ahmad Yani No. 5, Surabaya',
                'join_date' => Carbon::parse('2024-02-01'),
            ],
            [
                'name' => 'Dewi Lestari',
                'student_id' => '2024004',
                'email' => 'dewi.lestari@student.ac.id',
                'phone' => '081234567893',
                'address' => 'Jl. Gatot Subroto No. 15, Yogyakarta',
                'join_date' => Carbon::parse('2024-02-10'),
            ],
            [
                'name' => 'Rendra Pratama',
                'student_id' => '2024005',
                'email' => 'rendra.pratama@student.ac.id',
                'phone' => '081234567894',
                'address' => 'Jl. Diponegoro No. 20, Semarang',
                'join_date' => Carbon::parse('2024-02-15'),
            ],
            [
                'name' => 'Maya Anindita',
                'student_id' => '2024006',
                'email' => 'maya.anindita@student.ac.id',
                'phone' => '081234567895',
                'address' => 'Jl. Kartini No. 8, Malang',
                'join_date' => Carbon::parse('2024-03-01'),
            ],
            [
                'name' => 'Andi Wijaya',
                'student_id' => '2024007',
                'email' => 'andi.wijaya@student.ac.id',
                'phone' => '081234567896',
                'address' => 'Jl. Pemuda No. 12, Makassar',
                'join_date' => Carbon::parse('2024-03-05'),
            ],
            [
                'name' => 'Rina Susanti',
                'student_id' => '2024008',
                'email' => 'rina.susanti@student.ac.id',
                'phone' => '081234567897',
                'address' => 'Jl. Pahlawan No. 18, Medan',
                'join_date' => Carbon::parse('2024-03-10'),
            ],
            [
                'name' => 'Dimas Prasetyo',
                'student_id' => '2024009',
                'email' => 'dimas.prasetyo@student.ac.id',
                'phone' => '081234567898',
                'address' => 'Jl. Veteran No. 7, Palembang',
                'join_date' => Carbon::parse('2024-03-15'),
            ],
            [
                'name' => 'Ayu Puspitasari',
                'student_id' => '2024010',
                'email' => 'ayu.puspitasari@student.ac.id',
                'phone' => '081234567899',
                'address' => 'Jl. Asia Afrika No. 22, Denpasar',
                'join_date' => Carbon::parse('2024-03-20'),
            ],
            [
                'name' => 'Rizki Ramadhan',
                'student_id' => '2024011',
                'email' => 'rizki.ramadhan@student.ac.id',
                'phone' => '081234567800',
                'address' => 'Jl. Imam Bonjol No. 14, Padang',
                'join_date' => Carbon::parse('2024-04-01'),
            ],
            [
                'name' => 'Fitri Handayani',
                'student_id' => '2024012',
                'email' => 'fitri.handayani@student.ac.id',
                'phone' => '081234567801',
                'address' => 'Jl. Cendrawasih No. 9, Manado',
                'join_date' => Carbon::parse('2024-04-05'),
            ],
            [
                'name' => 'Hendra Gunawan',
                'student_id' => '2024013',
                'email' => 'hendra.gunawan@student.ac.id',
                'phone' => '081234567802',
                'address' => 'Jl. Melati No. 16, Banjarmasin',
                'join_date' => Carbon::parse('2024-04-10'),
            ],
            [
                'name' => 'Indah Permata',
                'student_id' => '2024014',
                'email' => 'indah.permata@student.ac.id',
                'phone' => '081234567803',
                'address' => 'Jl. Kenanga No. 11, Pontianak',
                'join_date' => Carbon::parse('2024-04-15'),
            ],
            [
                'name' => 'Yoga Aditya',
                'student_id' => '2024015',
                'email' => 'yoga.aditya@student.ac.id',
                'phone' => '081234567804',
                'address' => 'Jl. Anggrek No. 13, Balikpapan',
                'join_date' => Carbon::parse('2024-05-01'),
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
