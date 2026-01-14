<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Classification;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $member;
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);

        // Create category and classification
        $category = Category::factory()->create();
        $classification = Classification::factory()->create(['code' => '005']);

        // Create a book with available stock
        $this->book = Book::factory()->create([
            'title' => 'Test Book',
            'category_id' => $category->id,
            'classification_code' => $classification->code,
            'quantity' => 5,
            'available_quantity' => 5,
            'barcode' => 'BC001',
        ]);

        // Create a member
        $this->member = Member::factory()->create([
            'name' => 'Test Member',
            'student_id' => 'STU001',
            'email' => 'member@test.com',
        ]);
    }

    /**
     * Test complete borrowing workflow: create borrowing -> stock decrements
     */
    public function test_creating_borrowing_decrements_available_quantity()
    {
        $this->actingAs($this->admin);

        $initialQuantity = $this->book->available_quantity;

        $response = $this->post(route('admin.borrowings.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.borrowings.index'));
        $response->assertSessionHas('success');

        // Verify borrowing created
        $this->assertDatabaseHas('borrowings', [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'status' => 'borrowed',
        ]);

        // Verify stock decremented
        $this->book->refresh();
        $this->assertEquals($initialQuantity - 1, $this->book->available_quantity);
    }

    /**
     * Test returning book increments available quantity
     */
    public function test_returning_book_increments_available_quantity()
    {
        $this->actingAs($this->admin);

        // Create a borrowing
        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(5),
            'due_date' => now()->addDays(2),
            'status' => 'borrowed',
        ]);

        // Decrement stock manually (simulating the borrowing process)
        $this->book->decrement('available_quantity');
        $quantityAfterBorrow = $this->book->fresh()->available_quantity;

        // Return the book
        $response = $this->post(route('admin.borrowings.processReturn', $borrowing), [
            'return_date' => now()->format('Y-m-d'),
            'fine_amount' => 0,
        ]);

        $response->assertRedirect(route('admin.borrowings.index'));
        $response->assertSessionHas('success');

        // Verify borrowing marked as returned
        $borrowing->refresh();
        $this->assertEquals('returned', $borrowing->status);
        $this->assertNotNull($borrowing->return_date);

        // Verify stock incremented
        $this->book->refresh();
        $this->assertEquals($quantityAfterBorrow + 1, $this->book->available_quantity);
    }

    /**
     * Test complete workflow: borrow -> return with no fine (on time)
     */
    public function test_complete_workflow_on_time_return()
    {
        $this->actingAs($this->admin);

        $initialQuantity = $this->book->available_quantity;

        // Step 1: Create borrowing
        $this->post(route('admin.borrowings.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $borrowing = Borrowing::latest()->first();

        // Verify stock decreased
        $this->book->refresh();
        $this->assertEquals($initialQuantity - 1, $this->book->available_quantity);

        // Step 2: Return book on time
        $this->post(route('admin.borrowings.processReturn', $borrowing), [
            'return_date' => now()->addDays(5)->format('Y-m-d'), // Before due date
            'fine_amount' => null,
        ]);

        $borrowing->refresh();

        // Verify no fine charged
        $this->assertEquals(0, $borrowing->fine_amount);
        $this->assertEquals('returned', $borrowing->status);

        // Verify stock restored
        $this->book->refresh();
        $this->assertEquals($initialQuantity, $this->book->available_quantity);
    }

    /**
     * Test complete workflow: borrow -> return late with automatic fine
     */
    public function test_complete_workflow_late_return_with_fine()
    {
        $this->actingAs($this->admin);

        // Create borrowing with due date in the past
        $borrowDate = Carbon::now()->subDays(10);
        $dueDate = Carbon::now()->subDays(3); // 3 days overdue

        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'borrowed',
        ]);

        $this->book->decrement('available_quantity');
        $initialQuantity = $this->book->fresh()->available_quantity;

        // Return book 3 days late
        $returnDate = Carbon::now();
        $daysLate = $dueDate->startOfDay()->diffInDays($returnDate->startOfDay(), false);

        // Since we created due date 3 days ago and returning today, expect 3 days * 1000 = 3000
        $expectedFine = 3000;

        $this->post(route('admin.borrowings.processReturn', $borrowing), [
            'return_date' => $returnDate->format('Y-m-d'),
            'fine_amount' => null, // Let system calculate automatically
        ]);

        $borrowing->refresh();

        // Verify automatic fine calculation
        $this->assertEquals($expectedFine, $borrowing->fine_amount);
        $this->assertEquals('returned', $borrowing->status);

        // Verify stock restored
        $this->book->refresh();
        $this->assertEquals($initialQuantity + 1, $this->book->available_quantity);
    }

    /**
     * Test cannot borrow when book is not available
     */
    public function test_cannot_borrow_when_book_unavailable()
    {
        $this->actingAs($this->admin);

        // Set book as unavailable
        $this->book->update(['available_quantity' => 0]);

        $response = $this->post(route('admin.borrowings.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Buku tidak tersedia untuk dipinjam.');

        // Verify no borrowing created
        $this->assertDatabaseMissing('borrowings', [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
        ]);
    }

    /**
     * Test cannot borrow when member has overdue books
     */
    public function test_cannot_borrow_when_member_has_overdue_books()
    {
        $this->actingAs($this->admin);

        // Create an overdue borrowing for the member
        Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(14),
            'due_date' => now()->subDays(7), // 7 days overdue
            'status' => 'borrowed',
        ]);

        // Try to borrow another book
        $anotherBook = Book::factory()->create([
            'quantity' => 5,
            'available_quantity' => 5,
        ]);

        $response = $this->post(route('admin.borrowings.store'), [
            'member_id' => $this->member->id,
            'book_id' => $anotherBook->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anggota memiliki buku yang terlambat dikembalikan. Harap kembalikan terlebih dahulu.');
    }

    /**
     * Test cannot return already returned book
     */
    public function test_cannot_return_already_returned_book()
    {
        $this->actingAs($this->admin);

        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(5),
            'due_date' => now()->addDays(2),
            'status' => 'returned', // Already returned
            'return_date' => now(),
        ]);

        $response = $this->post(route('admin.borrowings.processReturn', $borrowing), [
            'return_date' => now()->format('Y-m-d'),
            'fine_amount' => 0,
        ]);

        $response->assertRedirect(route('admin.borrowings.index'));
        $response->assertSessionHas('error', 'Buku sudah dikembalikan.');
    }

    /**
     * Test manual fine override works
     */
    public function test_manual_fine_override_works()
    {
        $this->actingAs($this->admin);

        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => Carbon::now()->subDays(10),
            'due_date' => Carbon::now()->subDays(3), // 3 days overdue
            'status' => 'borrowed',
        ]);

        $this->book->decrement('available_quantity');

        // Manual fine override (e.g., waive or reduce fine)
        $manualFine = 5000; // Instead of automatic 3000

        $this->post(route('admin.borrowings.processReturn', $borrowing), [
            'return_date' => now()->format('Y-m-d'),
            'fine_amount' => $manualFine,
        ]);

        $borrowing->refresh();

        // Verify manual fine was used instead of automatic calculation
        $this->assertEquals($manualFine, $borrowing->fine_amount);
    }

    /**
     * Test multiple borrowings affect stock correctly
     */
    public function test_multiple_borrowings_affect_stock_correctly()
    {
        $this->actingAs($this->admin);

        $initialQuantity = $this->book->available_quantity;

        // Create 3 borrowings
        $member2 = Member::factory()->create();
        $member3 = Member::factory()->create();

        $this->post(route('admin.borrowings.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $this->post(route('admin.borrowings.store'), [
            'member_id' => $member2->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $this->post(route('admin.borrowings.store'), [
            'member_id' => $member3->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        // Verify stock decreased by 3
        $this->book->refresh();
        $this->assertEquals($initialQuantity - 3, $this->book->available_quantity);

        // Return 2 books
        $borrowings = Borrowing::where('book_id', $this->book->id)->get();

        $this->post(route('admin.borrowings.processReturn', $borrowings[0]), [
            'return_date' => now()->format('Y-m-d'),
            'fine_amount' => 0,
        ]);

        $this->post(route('admin.borrowings.processReturn', $borrowings[1]), [
            'return_date' => now()->format('Y-m-d'),
            'fine_amount' => 0,
        ]);

        // Verify stock increased by 2
        $this->book->refresh();
        $this->assertEquals($initialQuantity - 1, $this->book->available_quantity);
    }

    /**
     * Test cannot delete active borrowing
     */
    public function test_cannot_delete_active_borrowing()
    {
        $this->actingAs($this->admin);

        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'borrowed',
        ]);

        $response = $this->delete(route('admin.borrowings.destroy', $borrowing));

        $response->assertRedirect(route('admin.borrowings.index'));
        $response->assertSessionHas('error', 'Tidak dapat menghapus peminjaman yang masih aktif.');

        // Verify borrowing still exists
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'borrowed',
        ]);
    }

    /**
     * Test can delete returned borrowing
     */
    public function test_can_delete_returned_borrowing()
    {
        $this->actingAs($this->admin);

        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10),
            'due_date' => now()->subDays(3),
            'return_date' => now()->subDays(1),
            'status' => 'returned',
        ]);

        $response = $this->delete(route('admin.borrowings.destroy', $borrowing));

        $response->assertRedirect(route('admin.borrowings.index'));
        $response->assertSessionHas('success');

        // Verify borrowing deleted
        $this->assertDatabaseMissing('borrowings', [
            'id' => $borrowing->id,
        ]);
    }
}
