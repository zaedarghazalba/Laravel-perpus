<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Classification;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;
    protected $classification;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->category = Category::factory()->create();
        $this->classification = Classification::factory()->create(['code' => '005']);
    }

    /**
     * Test creating book sets available_quantity equal to quantity
     */
    public function test_creating_book_sets_available_quantity_equal_to_quantity()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'New Book',
            'author' => 'Test Author',
            'publisher' => 'Test Publisher',
            'isbn' => '9781234567890',
            'barcode' => 'BC001',
            'publication_year' => 2024,
            'category_id' => $this->category->id,
            'classification_code' => $this->classification->code,
            'quantity' => 10,
        ]);

        $response->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseHas('books', [
            'title' => 'New Book',
            'quantity' => 10,
            'available_quantity' => 10,
        ]);
    }

    /**
     * Test updating book quantity increases available_quantity proportionally
     */
    public function test_updating_book_quantity_increases_available_quantity()
    {
        $this->actingAs($this->admin);

        // Create book with 10 total, 10 available
        $book = Book::factory()->create([
            'category_id' => $this->category->id,
            'quantity' => 10,
            'available_quantity' => 10,
        ]);

        // Update quantity to 15 (add 5 more books)
        $response = $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'quantity' => 15,
        ]);

        $response->assertRedirect(route('admin.books.index'));

        $book->refresh();
        $this->assertEquals(15, $book->quantity);
        $this->assertEquals(15, $book->available_quantity);
    }

    /**
     * Test updating book quantity with borrowed books calculates correctly
     */
    public function test_updating_quantity_with_borrowed_books_calculates_correctly()
    {
        $this->actingAs($this->admin);

        // Create book: 10 total, 7 available (3 borrowed)
        $book = Book::factory()->create([
            'category_id' => $this->category->id,
            'quantity' => 10,
            'available_quantity' => 7,
        ]);

        // Increase quantity to 15 (add 5 more)
        // Expected: available should be 7 + 5 = 12
        $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'quantity' => 15,
        ]);

        $book->refresh();
        $this->assertEquals(15, $book->quantity);
        $this->assertEquals(12, $book->available_quantity);
    }

    /**
     * Test decreasing book quantity reduces available_quantity
     */
    public function test_decreasing_quantity_reduces_available_quantity()
    {
        $this->actingAs($this->admin);

        // Create book: 10 total, 10 available
        $book = Book::factory()->create([
            'category_id' => $this->category->id,
            'quantity' => 10,
            'available_quantity' => 10,
        ]);

        // Decrease quantity to 7 (remove 3 books)
        $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'quantity' => 7,
        ]);

        $book->refresh();
        $this->assertEquals(7, $book->quantity);
        $this->assertEquals(7, $book->available_quantity);
    }

    /**
     * Test available_quantity cannot go below zero when decreasing
     */
    public function test_available_quantity_cannot_go_below_zero()
    {
        $this->actingAs($this->admin);

        // Create book: 10 total, 3 available (7 borrowed)
        $book = Book::factory()->create([
            'category_id' => $this->category->id,
            'quantity' => 10,
            'available_quantity' => 3,
        ]);

        // Try to decrease quantity to 5 (which would make available = 3 + (5-10) = -2)
        // System should set it to 0 instead
        $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'quantity' => 5,
        ]);

        $book->refresh();
        $this->assertEquals(5, $book->quantity);
        $this->assertEquals(0, $book->available_quantity);
    }

    /**
     * Test shelf location auto-generation on create
     */
    public function test_shelf_location_auto_generated_on_create()
    {
        $this->actingAs($this->admin);

        // Create classification first
        $classification = Classification::factory()->create(['code' => '005.133']);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'Computer Science Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'classification_code' => '005.133', // Should map to Rak A-1
            'quantity' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('books', [
            'title' => 'Computer Science Book',
            'classification_code' => '005.133',
            'shelf_location' => 'Rak A-1',
        ]);
    }

    /**
     * Test manual shelf location not overridden
     */
    public function test_manual_shelf_location_not_overridden()
    {
        $this->actingAs($this->admin);

        // Create classification first
        $classification = Classification::factory()->create(['code' => '005.133']);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'Special Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'classification_code' => '005.133',
            'shelf_location' => 'Custom-Location-1', // Manual location
            'quantity' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('books', [
            'title' => 'Special Book',
            'shelf_location' => 'Custom-Location-1', // Should keep manual value
        ]);
    }

    /**
     * Test ISBN uniqueness validation
     */
    public function test_isbn_must_be_unique()
    {
        $this->actingAs($this->admin);

        // Create first book with ISBN
        Book::factory()->create([
            'isbn' => '9781234567890',
            'category_id' => $this->category->id,
        ]);

        // Try to create another with same ISBN
        $response = $this->post(route('admin.books.store'), [
            'title' => 'Duplicate ISBN Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'isbn' => '9781234567890', // Duplicate
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors('isbn');
    }

    /**
     * Test barcode uniqueness validation
     */
    public function test_barcode_must_be_unique()
    {
        $this->actingAs($this->admin);

        Book::factory()->create([
            'barcode' => 'BC001',
            'category_id' => $this->category->id,
        ]);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'Duplicate Barcode Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'barcode' => 'BC001', // Duplicate
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors('barcode');
    }

    /**
     * Test publication year validation
     */
    public function test_publication_year_validation()
    {
        $this->actingAs($this->admin);

        $currentYear = date('Y');

        // Test invalid year (too old)
        $response = $this->post(route('admin.books.store'), [
            'title' => 'Ancient Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'publication_year' => 999, // Before year 1000
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors('publication_year');

        // Test invalid year (future)
        $response = $this->post(route('admin.books.store'), [
            'title' => 'Future Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'publication_year' => $currentYear + 10, // Too far in future
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors('publication_year');

        // Test valid year (current + 1)
        $response = $this->post(route('admin.books.store'), [
            'title' => 'Next Year Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'publication_year' => $currentYear + 1, // Valid
            'quantity' => 5,
        ]);

        $response->assertSessionDoesntHaveErrors('publication_year');
    }

    /**
     * Test required fields validation
     */
    public function test_required_fields_validation()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.books.store'), [
            // Missing: title, author, category_id, quantity
        ]);

        $response->assertSessionHasErrors(['title', 'author', 'category_id', 'quantity']);
    }

    /**
     * Test cannot delete book with active borrowings
     */
    public function test_cannot_delete_book_with_active_borrowings()
    {
        $this->actingAs($this->admin);

        $book = Book::factory()->create(['category_id' => $this->category->id]);
        $member = Member::factory()->create();

        // Create active borrowing
        Borrowing::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'borrowed',
        ]);

        $response = $this->delete(route('admin.books.destroy', $book));

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('error', 'Tidak dapat menghapus buku yang sedang dipinjam.');

        // Verify book still exists
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    /**
     * Test can delete book with returned borrowings
     */
    public function test_can_delete_book_with_returned_borrowings()
    {
        $this->actingAs($this->admin);

        $book = Book::factory()->create(['category_id' => $this->category->id]);
        $member = Member::factory()->create();

        // Create returned borrowing
        Borrowing::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => now()->subDays(10),
            'due_date' => now()->subDays(3),
            'return_date' => now()->subDays(1),
            'status' => 'returned',
        ]);

        $response = $this->delete(route('admin.books.destroy', $book));

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        // Verify book deleted
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test can delete book with no borrowings
     */
    public function test_can_delete_book_with_no_borrowings()
    {
        $this->actingAs($this->admin);

        $book = Book::factory()->create(['category_id' => $this->category->id]);

        $response = $this->delete(route('admin.books.destroy', $book));

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test quantity must be non-negative
     */
    public function test_quantity_must_be_non_negative()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'Negative Quantity Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'quantity' => -5, // Invalid
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    /**
     * Test updating ISBN allows keeping same ISBN
     */
    public function test_updating_isbn_allows_keeping_same_isbn()
    {
        $this->actingAs($this->admin);

        $book = Book::factory()->create([
            'isbn' => '9781234567890',
            'category_id' => $this->category->id,
        ]);

        // Update book with same ISBN (should be allowed)
        $response = $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'isbn' => '9781234567890', // Same ISBN
            'quantity' => $book->quantity,
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * Test updating barcode allows keeping same barcode
     */
    public function test_updating_barcode_allows_keeping_same_barcode()
    {
        $this->actingAs($this->admin);

        $book = Book::factory()->create([
            'barcode' => 'BC001',
            'category_id' => $this->category->id,
        ]);

        $response = $this->put(route('admin.books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'category_id' => $this->category->id,
            'barcode' => 'BC001', // Same barcode
            'quantity' => $book->quantity,
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * Test classification code must exist in classifications table
     */
    public function test_classification_code_must_exist()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.books.store'), [
            'title' => 'Invalid Classification Book',
            'author' => 'Test Author',
            'category_id' => $this->category->id,
            'classification_code' => '999.999', // Non-existent
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors('classification_code');
    }
}
