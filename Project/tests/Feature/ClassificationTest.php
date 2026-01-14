<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Classification;
use App\Models\Ebook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassificationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /**
     * Test creating classification with valid data
     */
    public function test_can_create_classification()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.classifications.store'), [
            'code' => '000',
            'name' => 'Computer Science',
            'description' => 'Computer science, information & general works',
            'parent_code' => null,
            'level' => 1,
        ]);

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('classifications', [
            'code' => '000',
            'name' => 'Computer Science',
            'level' => 1,
        ]);
    }

    /**
     * Test code uniqueness validation
     */
    public function test_classification_code_must_be_unique()
    {
        $this->actingAs($this->admin);

        // Create first classification
        Classification::factory()->create(['code' => '000']);

        // Try to create another with same code
        $response = $this->post(route('admin.classifications.store'), [
            'code' => '000', // Duplicate
            'name' => 'Duplicate',
            'level' => 1,
        ]);

        $response->assertSessionHasErrors('code');
    }

    /**
     * Test parent-child relationship
     */
    public function test_classification_parent_child_relationship()
    {
        // Create parent
        $parent = Classification::factory()->create([
            'code' => '000',
            'name' => 'Computer Science',
            'level' => 1,
        ]);

        // Create child
        $child = Classification::factory()->create([
            'code' => '005',
            'name' => 'Programming',
            'parent_code' => '000',
            'level' => 2,
        ]);

        // Test relationships
        $this->assertEquals('000', $child->parent->code);
        $this->assertTrue($parent->children->contains($child));
        $this->assertEquals(1, $parent->children->count());
    }

    /**
     * Test cannot delete classification with children
     */
    public function test_cannot_delete_classification_with_children()
    {
        $this->actingAs($this->admin);

        // Create parent and child
        $parent = Classification::factory()->create(['code' => '000', 'level' => 1]);
        Classification::factory()->create([
            'code' => '005',
            'parent_code' => '000',
            'level' => 2,
        ]);

        $response = $this->delete(route('admin.classifications.destroy', $parent));

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionHas('error', 'Klasifikasi tidak dapat dihapus karena masih memiliki sub-klasifikasi!');

        // Verify parent still exists
        $this->assertDatabaseHas('classifications', ['code' => '000']);
    }

    /**
     * Test cannot delete classification with books
     */
    public function test_cannot_delete_classification_with_books()
    {
        $this->actingAs($this->admin);

        $classification = Classification::factory()->create(['code' => '005']);
        $category = Category::factory()->create();

        // Create book with this classification
        Book::factory()->create([
            'classification_code' => '005',
            'category_id' => $category->id,
        ]);

        $response = $this->delete(route('admin.classifications.destroy', $classification));

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionHas('error', 'Klasifikasi tidak dapat dihapus karena masih digunakan oleh buku/ebook!');

        // Verify classification still exists
        $this->assertDatabaseHas('classifications', ['code' => '005']);
    }

    /**
     * Test cannot delete classification with ebooks
     */
    public function test_cannot_delete_classification_with_ebooks()
    {
        $this->actingAs($this->admin);

        $classification = Classification::factory()->create(['code' => '005']);
        $category = Category::factory()->create();

        // Create ebook with this classification
        Ebook::factory()->create([
            'classification_code' => '005',
            'category_id' => $category->id,
        ]);

        $response = $this->delete(route('admin.classifications.destroy', $classification));

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionHas('error', 'Klasifikasi tidak dapat dihapus karena masih digunakan oleh buku/ebook!');

        $this->assertDatabaseHas('classifications', ['code' => '005']);
    }

    /**
     * Test can delete classification with no dependencies
     */
    public function test_can_delete_classification_with_no_dependencies()
    {
        $this->actingAs($this->admin);

        $classification = Classification::factory()->create(['code' => '005']);

        $response = $this->delete(route('admin.classifications.destroy', $classification));

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('classifications', ['code' => '005']);
    }

    /**
     * Test parent_code must exist in classifications table
     */
    public function test_parent_code_must_exist()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.classifications.store'), [
            'code' => '005',
            'name' => 'Programming',
            'parent_code' => '999', // Non-existent
            'level' => 2,
        ]);

        $response->assertSessionHasErrors('parent_code');
    }

    /**
     * Test level validation (1-10)
     */
    public function test_level_validation()
    {
        $this->actingAs($this->admin);

        // Test level 0 (invalid)
        $response = $this->post(route('admin.classifications.store'), [
            'code' => '005',
            'name' => 'Test',
            'level' => 0,
        ]);

        $response->assertSessionHasErrors('level');

        // Test level 11 (invalid)
        $response = $this->post(route('admin.classifications.store'), [
            'code' => '006',
            'name' => 'Test',
            'level' => 11,
        ]);

        $response->assertSessionHasErrors('level');

        // Test level 1 (valid)
        $response = $this->post(route('admin.classifications.store'), [
            'code' => '007',
            'name' => 'Test',
            'level' => 1,
        ]);

        $response->assertSessionDoesntHaveErrors('level');

        // Test level 10 (valid)
        $response = $this->post(route('admin.classifications.store'), [
            'code' => '008',
            'name' => 'Test',
            'level' => 10,
        ]);

        $response->assertSessionDoesntHaveErrors('level');
    }

    /**
     * Test get children AJAX endpoint
     */
    public function test_get_children_endpoint_returns_correct_children()
    {
        $this->actingAs($this->admin);

        // Create parent
        $parent = Classification::factory()->create(['code' => '000', 'level' => 1]);

        // Create children
        $child1 = Classification::factory()->create([
            'code' => '001',
            'parent_code' => '000',
            'level' => 2,
        ]);

        $child2 = Classification::factory()->create([
            'code' => '005',
            'parent_code' => '000',
            'level' => 2,
        ]);

        // Create unrelated classification
        Classification::factory()->create([
            'code' => '100',
            'parent_code' => null,
            'level' => 1,
        ]);

        $response = $this->get(route('admin.classifications.children', ['code' => '000']));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $children = $response->json('children');

        $this->assertCount(2, $children);
        $this->assertEquals('001', $children[0]['code']);
        $this->assertEquals('005', $children[1]['code']);
    }

    /**
     * Test get children endpoint returns empty for leaf nodes
     */
    public function test_get_children_returns_empty_for_leaf_nodes()
    {
        $this->actingAs($this->admin);

        $leaf = Classification::factory()->create(['code' => '005', 'level' => 2]);

        $response = $this->get(route('admin.classifications.children', ['code' => '005']));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'children' => [],
        ]);
    }

    /**
     * Test mainClassifications scope
     */
    public function test_main_classifications_scope()
    {
        // Create level 1 classifications
        Classification::factory()->create(['code' => '000', 'level' => 1]);
        Classification::factory()->create(['code' => '100', 'level' => 1]);

        // Create level 2 classifications
        Classification::factory()->create(['code' => '005', 'level' => 2]);
        Classification::factory()->create(['code' => '150', 'level' => 2]);

        $mainClassifications = Classification::mainClassifications()->get();

        $this->assertCount(2, $mainClassifications);
        $this->assertEquals('000', $mainClassifications[0]->code);
        $this->assertEquals('100', $mainClassifications[1]->code);
    }

    /**
     * Test level scope
     */
    public function test_level_scope()
    {
        Classification::factory()->create(['code' => '000', 'level' => 1]);
        Classification::factory()->create(['code' => '005', 'level' => 2]);
        Classification::factory()->create(['code' => '005.1', 'level' => 3]);
        Classification::factory()->create(['code' => '100', 'level' => 1]);

        $level2 = Classification::level(2)->get();

        $this->assertCount(1, $level2);
        $this->assertEquals('005', $level2[0]->code);
        $this->assertEquals(2, $level2[0]->level);
    }

    /**
     * Test multiple levels of hierarchy
     */
    public function test_multiple_levels_of_hierarchy()
    {
        // Level 1
        $level1 = Classification::factory()->create([
            'code' => '000',
            'name' => 'Computer Science',
            'level' => 1,
        ]);

        // Level 2
        $level2 = Classification::factory()->create([
            'code' => '005',
            'name' => 'Programming',
            'parent_code' => '000',
            'level' => 2,
        ]);

        // Level 3
        $level3 = Classification::factory()->create([
            'code' => '005.1',
            'name' => 'Programming Principles',
            'parent_code' => '005',
            'level' => 3,
        ]);

        // Test relationships
        $this->assertEquals('000', $level2->parent->code);
        $this->assertEquals('005', $level3->parent->code);
        $this->assertEquals(1, $level1->children->count());
        $this->assertEquals(1, $level2->children->count());
        $this->assertEquals(0, $level3->children->count());
    }

    /**
     * Test updating classification allows keeping same code
     */
    public function test_updating_classification_allows_keeping_same_code()
    {
        $this->actingAs($this->admin);

        $classification = Classification::factory()->create(['code' => '005']);

        $response = $this->put(route('admin.classifications.update', $classification), [
            'code' => '005', // Same code
            'name' => 'Updated Name',
            'level' => 1,
        ]);

        $response->assertRedirect(route('admin.classifications.index'));
        $response->assertSessionDoesntHaveErrors();

        $classification->refresh();
        $this->assertEquals('Updated Name', $classification->name);
    }

    /**
     * Test required fields validation
     */
    public function test_required_fields_validation()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.classifications.store'), [
            // Missing: code, name, level
        ]);

        $response->assertSessionHasErrors(['code', 'name', 'level']);
    }

    /**
     * Test filtering by level
     */
    public function test_filtering_by_level()
    {
        $this->actingAs($this->admin);

        Classification::factory()->create(['code' => '000', 'level' => 1]);
        Classification::factory()->create(['code' => '005', 'level' => 2]);
        Classification::factory()->create(['code' => '100', 'level' => 1]);

        $response = $this->get(route('admin.classifications.index', ['level' => 1]));

        $response->assertStatus(200);
        $response->assertSee('000');
        $response->assertSee('100');
    }

    /**
     * Test search functionality
     */
    public function test_search_functionality()
    {
        $this->actingAs($this->admin);

        Classification::factory()->create([
            'code' => '000',
            'name' => 'Computer Science',
            'description' => 'CS and IT',
        ]);

        Classification::factory()->create([
            'code' => '100',
            'name' => 'Philosophy',
            'description' => 'Philosophy and psychology',
        ]);

        // Search by code
        $response = $this->get(route('admin.classifications.index', ['search' => '000']));
        $response->assertSee('Computer Science');
        $response->assertDontSee('Philosophy');

        // Search by name
        $response = $this->get(route('admin.classifications.index', ['search' => 'Philosophy']));
        $response->assertSee('Philosophy');
        $response->assertDontSee('Computer Science');

        // Search by description
        $response = $this->get(route('admin.classifications.index', ['search' => 'psychology']));
        $response->assertSee('Philosophy');
    }
}
