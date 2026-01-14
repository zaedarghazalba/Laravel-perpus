<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all books, members, and users
        $books = Book::all();
        $members = Member::all();
        $users = User::all();

        // Borrowings data
        $borrowings = [
            // Returned - On Time (No Fine)
            [
                'member_id' => $members[0]->id, // Ahmad Fauzi
                'book_id' => $books[0]->id, // Laskar Pelangi
                'borrow_date' => Carbon::parse('2025-12-01'),
                'due_date' => Carbon::parse('2025-12-08'),
                'return_date' => Carbon::parse('2025-12-07'),
                'status' => 'returned',
                'fine_amount' => 0,
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[1]->id, // Siti Nurhaliza
                'book_id' => $books[4]->id, // Filosofi Teras
                'borrow_date' => Carbon::parse('2025-12-05'),
                'due_date' => Carbon::parse('2025-12-12'),
                'return_date' => Carbon::parse('2025-12-11'),
                'status' => 'returned',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],

            // Returned - Late (With Fine)
            [
                'member_id' => $members[2]->id, // Budi Santoso
                'book_id' => $books[5]->id, // Algoritma dan Struktur Data
                'borrow_date' => Carbon::parse('2025-11-15'),
                'due_date' => Carbon::parse('2025-11-22'),
                'return_date' => Carbon::parse('2025-11-27'),
                'status' => 'returned',
                'fine_amount' => 5000, // 5 days late
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[3]->id, // Dewi Lestari
                'book_id' => $books[1]->id, // Bumi Manusia
                'borrow_date' => Carbon::parse('2025-11-20'),
                'due_date' => Carbon::parse('2025-11-27'),
                'return_date' => Carbon::parse('2025-12-01'),
                'status' => 'returned',
                'fine_amount' => 4000, // 4 days late
                'created_by' => $users[1]->id, // Staff
            ],
            [
                'member_id' => $members[4]->id, // Rendra Pratama
                'book_id' => $books[8]->id, // Sejarah Nasional Indonesia
                'borrow_date' => Carbon::parse('2025-11-10'),
                'due_date' => Carbon::parse('2025-11-17'),
                'return_date' => Carbon::parse('2025-11-20'),
                'status' => 'returned',
                'fine_amount' => 3000, // 3 days late
                'created_by' => $users[0]->id, // Admin
            ],

            // Borrowed - Still On Time
            [
                'member_id' => $members[5]->id, // Maya Anindita
                'book_id' => $books[3]->id, // Perahu Kertas
                'borrow_date' => Carbon::parse('2026-01-08'),
                'due_date' => Carbon::parse('2026-01-15'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],
            [
                'member_id' => $members[6]->id, // Andi Wijaya
                'book_id' => $books[7]->id, // Fisika untuk Sains dan Teknik
                'borrow_date' => Carbon::parse('2026-01-10'),
                'due_date' => Carbon::parse('2026-01-17'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[7]->id, // Rina Susanti
                'book_id' => $books[12]->id, // Habibie & Ainun
                'borrow_date' => Carbon::parse('2026-01-09'),
                'due_date' => Carbon::parse('2026-01-16'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],

            // Borrowed - Overdue (Late)
            [
                'member_id' => $members[8]->id, // Dimas Prasetyo
                'book_id' => $books[2]->id, // Ronggeng Dukuh Paruk
                'borrow_date' => Carbon::parse('2025-12-25'),
                'due_date' => Carbon::parse('2026-01-01'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0, // Will calculate on return
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[9]->id, // Ayu Puspitasari
                'book_id' => $books[6]->id, // Pengantar Kecerdasan Buatan
                'borrow_date' => Carbon::parse('2025-12-28'),
                'due_date' => Carbon::parse('2026-01-04'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0, // Will calculate on return
                'created_by' => $users[1]->id, // Staff
            ],

            // More Returned Books
            [
                'member_id' => $members[10]->id, // Rizki Ramadhan
                'book_id' => $books[13]->id, // Kamus Besar Bahasa Indonesia
                'borrow_date' => Carbon::parse('2025-12-01'),
                'due_date' => Carbon::parse('2025-12-08'),
                'return_date' => Carbon::parse('2025-12-08'),
                'status' => 'returned',
                'fine_amount' => 0,
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[11]->id, // Fitri Handayani
                'book_id' => $books[9]->id, // Indonesia dalam Arus Sejarah
                'borrow_date' => Carbon::parse('2025-12-10'),
                'due_date' => Carbon::parse('2025-12-17'),
                'return_date' => Carbon::parse('2025-12-16'),
                'status' => 'returned',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],

            // More Borrowed Books
            [
                'member_id' => $members[12]->id, // Hendra Gunawan
                'book_id' => $books[14]->id, // Ensiklopedia Indonesia
                'borrow_date' => Carbon::parse('2026-01-11'),
                'due_date' => Carbon::parse('2026-01-18'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[0]->id, // Admin
            ],
            [
                'member_id' => $members[13]->id, // Indah Permata
                'book_id' => $books[19]->id, // Garudayana
                'borrow_date' => Carbon::parse('2026-01-12'),
                'due_date' => Carbon::parse('2026-01-19'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],
            [
                'member_id' => $members[14]->id, // Yoga Aditya
                'book_id' => $books[10]->id, // Perang Jawa 1825-1830
                'borrow_date' => Carbon::parse('2026-01-07'),
                'due_date' => Carbon::parse('2026-01-14'),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'created_by' => $users[0]->id, // Admin
            ],

            // Additional historical borrowings
            [
                'member_id' => $members[0]->id, // Ahmad Fauzi (2nd borrowing)
                'book_id' => $books[17]->id, // Dongeng-Dongeng Nusantara
                'borrow_date' => Carbon::parse('2025-11-01'),
                'due_date' => Carbon::parse('2025-11-08'),
                'return_date' => Carbon::parse('2025-11-07'),
                'status' => 'returned',
                'fine_amount' => 0,
                'created_by' => $users[1]->id, // Staff
            ],
            [
                'member_id' => $members[1]->id, // Siti Nurhaliza (2nd borrowing)
                'book_id' => $books[18]->id, // Si Juki
                'borrow_date' => Carbon::parse('2025-10-15'),
                'due_date' => Carbon::parse('2025-10-22'),
                'return_date' => Carbon::parse('2025-10-25'),
                'status' => 'returned',
                'fine_amount' => 3000, // 3 days late
                'created_by' => $users[0]->id, // Admin
            ],
        ];

        foreach ($borrowings as $borrowingData) {
            // Create the borrowing
            Borrowing::create($borrowingData);

            // Update book's available_quantity if still borrowed
            if ($borrowingData['status'] === 'borrowed') {
                $book = Book::find($borrowingData['book_id']);
                $book->decrement('available_quantity');
            }
        }
    }
}
