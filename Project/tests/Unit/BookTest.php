<?php

namespace Tests\Unit;

use App\Models\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    /**
     * Test shelf location generation for DDC range 000-099 (Computer science)
     */
    public function test_generates_shelf_location_for_computer_science_range()
    {
        $this->assertEquals('Rak A-1', Book::generateShelfLocation('000'));
        $this->assertEquals('Rak A-1', Book::generateShelfLocation('000.001'));
        $this->assertEquals('Rak A-1', Book::generateShelfLocation('005.133'));
        $this->assertEquals('Rak A-2', Book::generateShelfLocation('010'));
        $this->assertEquals('Rak A-3', Book::generateShelfLocation('025.04'));
        $this->assertEquals('Rak A-5', Book::generateShelfLocation('040'));
        $this->assertEquals('Rak A-10', Book::generateShelfLocation('095.5'));
    }

    /**
     * Test shelf location generation for DDC range 100-199 (Philosophy & psychology)
     */
    public function test_generates_shelf_location_for_philosophy_range()
    {
        $this->assertEquals('Rak B-1', Book::generateShelfLocation('100'));
        $this->assertEquals('Rak B-2', Book::generateShelfLocation('110.5'));
        $this->assertEquals('Rak B-4', Book::generateShelfLocation('130'));
        $this->assertEquals('Rak B-6', Book::generateShelfLocation('150.19'));
        $this->assertEquals('Rak B-10', Book::generateShelfLocation('199'));
    }

    /**
     * Test shelf location generation for DDC range 200-299 (Religion)
     */
    public function test_generates_shelf_location_for_religion_range()
    {
        $this->assertEquals('Rak C-1', Book::generateShelfLocation('200'));
        $this->assertEquals('Rak C-3', Book::generateShelfLocation('220'));
        $this->assertEquals('Rak C-8', Book::generateShelfLocation('270'));
        $this->assertEquals('Rak C-10', Book::generateShelfLocation('297.122'));
    }

    /**
     * Test shelf location generation for DDC range 300-399 (Social sciences)
     */
    public function test_generates_shelf_location_for_social_sciences_range()
    {
        $this->assertEquals('Rak D-1', Book::generateShelfLocation('300'));
        $this->assertEquals('Rak D-3', Book::generateShelfLocation('320.973'));
        $this->assertEquals('Rak D-4', Book::generateShelfLocation('330'));
        $this->assertEquals('Rak D-7', Book::generateShelfLocation('361'));
        $this->assertEquals('Rak D-10', Book::generateShelfLocation('395'));
    }

    /**
     * Test shelf location generation for DDC range 400-499 (Language)
     */
    public function test_generates_shelf_location_for_language_range()
    {
        $this->assertEquals('Rak E-1', Book::generateShelfLocation('400'));
        $this->assertEquals('Rak E-3', Book::generateShelfLocation('420'));
        $this->assertEquals('Rak E-6', Book::generateShelfLocation('450'));
        $this->assertEquals('Rak E-10', Book::generateShelfLocation('495.7'));
    }

    /**
     * Test shelf location generation for DDC range 500-599 (Science)
     */
    public function test_generates_shelf_location_for_science_range()
    {
        $this->assertEquals('Rak F-1', Book::generateShelfLocation('500'));
        $this->assertEquals('Rak F-2', Book::generateShelfLocation('510'));
        $this->assertEquals('Rak F-3', Book::generateShelfLocation('520'));
        $this->assertEquals('Rak F-4', Book::generateShelfLocation('530.12'));
        $this->assertEquals('Rak F-8', Book::generateShelfLocation('570'));
        $this->assertEquals('Rak F-10', Book::generateShelfLocation('599'));
    }

    /**
     * Test shelf location generation for DDC range 600-699 (Technology)
     */
    public function test_generates_shelf_location_for_technology_range()
    {
        $this->assertEquals('Rak G-1', Book::generateShelfLocation('600'));
        $this->assertEquals('Rak G-2', Book::generateShelfLocation('610'));
        $this->assertEquals('Rak G-5', Book::generateShelfLocation('641.5'));
        $this->assertEquals('Rak G-7', Book::generateShelfLocation('660'));
        $this->assertEquals('Rak G-10', Book::generateShelfLocation('690'));
    }

    /**
     * Test shelf location generation for DDC range 700-799 (Arts & recreation)
     */
    public function test_generates_shelf_location_for_arts_range()
    {
        $this->assertEquals('Rak H-1', Book::generateShelfLocation('700'));
        $this->assertEquals('Rak H-3', Book::generateShelfLocation('720'));
        $this->assertEquals('Rak H-6', Book::generateShelfLocation('750'));
        $this->assertEquals('Rak H-9', Book::generateShelfLocation('780'));
        $this->assertEquals('Rak H-10', Book::generateShelfLocation('796.332'));
    }

    /**
     * Test shelf location generation for DDC range 800-899 (Literature)
     */
    public function test_generates_shelf_location_for_literature_range()
    {
        $this->assertEquals('Rak I-1', Book::generateShelfLocation('800'));
        $this->assertEquals('Rak I-2', Book::generateShelfLocation('810'));
        $this->assertEquals('Rak I-3', Book::generateShelfLocation('820'));
        $this->assertEquals('Rak I-4', Book::generateShelfLocation('830'));
        $this->assertEquals('Rak I-10', Book::generateShelfLocation('895.1'));
    }

    /**
     * Test shelf location generation for DDC range 900-999 (History & geography)
     */
    public function test_generates_shelf_location_for_history_range()
    {
        $this->assertEquals('Rak J-1', Book::generateShelfLocation('900'));
        $this->assertEquals('Rak J-2', Book::generateShelfLocation('910'));
        $this->assertEquals('Rak J-5', Book::generateShelfLocation('940'));
        $this->assertEquals('Rak J-6', Book::generateShelfLocation('959.8'));
        $this->assertEquals('Rak J-10', Book::generateShelfLocation('999'));
    }

    /**
     * Test shelf location generation edge cases
     */
    public function test_generates_shelf_location_for_edge_cases()
    {
        // Empty string
        $this->assertNull(Book::generateShelfLocation(''));

        // Null value
        $this->assertNull(Book::generateShelfLocation(null));

        // Zero value (string "0" is considered empty, returns null)
        $this->assertNull(Book::generateShelfLocation('0'));

        // Maximum value (999)
        $this->assertEquals('Rak J-10', Book::generateShelfLocation('999'));

        // With decimal places
        $this->assertEquals('Rak F-4', Book::generateShelfLocation('530.12'));
        $this->assertEquals('Rak I-10', Book::generateShelfLocation('895.621'));
    }

    /**
     * Test shelf location generation for boundary values
     */
    public function test_generates_shelf_location_for_boundary_values()
    {
        // Boundaries between racks (hundreds)
        $this->assertEquals('Rak A-10', Book::generateShelfLocation('99'));
        $this->assertEquals('Rak B-1', Book::generateShelfLocation('100'));

        $this->assertEquals('Rak B-10', Book::generateShelfLocation('199'));
        $this->assertEquals('Rak C-1', Book::generateShelfLocation('200'));

        $this->assertEquals('Rak C-10', Book::generateShelfLocation('299'));
        $this->assertEquals('Rak D-1', Book::generateShelfLocation('300'));

        // Boundaries between shelves (tens)
        $this->assertEquals('Rak A-1', Book::generateShelfLocation('000'));
        $this->assertEquals('Rak A-1', Book::generateShelfLocation('009'));
        $this->assertEquals('Rak A-2', Book::generateShelfLocation('010'));
        $this->assertEquals('Rak A-2', Book::generateShelfLocation('019'));
        $this->assertEquals('Rak A-3', Book::generateShelfLocation('020'));
    }

    /**
     * Test shelf location generation for all racks (A-J)
     */
    public function test_generates_all_rack_letters()
    {
        $expectedRacks = ['Rak A', 'Rak B', 'Rak C', 'Rak D', 'Rak E', 'Rak F', 'Rak G', 'Rak H', 'Rak I', 'Rak J'];

        foreach ($expectedRacks as $index => $rack) {
            if ($index === 0) {
                // Special case: "0" string is considered empty
                $result = Book::generateShelfLocation("1");
                $this->assertStringStartsWith($rack, $result, "Classification 1 should map to {$rack}");
            } else {
                $classificationCode = $index * 100;
                $result = Book::generateShelfLocation((string)$classificationCode);
                $this->assertStringStartsWith($rack, $result, "Classification {$classificationCode} should map to {$rack}");
            }
        }
    }

    /**
     * Test shelf location generation for all shelf numbers (1-10)
     */
    public function test_generates_all_shelf_numbers()
    {
        for ($i = 0; $i < 10; $i++) {
            $shelfNumber = $i + 1;
            if ($i === 0) {
                // Special case: "0" string is considered empty, use "1" instead
                $classificationCode = 1;
            } else {
                $classificationCode = $i * 10; // 10, 20, 30, ..., 90
            }
            $result = Book::generateShelfLocation((string)$classificationCode);
            $this->assertStringEndsWith((string)$shelfNumber, $result, "Classification {$classificationCode} should map to shelf {$shelfNumber}");
        }
    }

    /**
     * Test shelf location consistency - same input always produces same output
     */
    public function test_shelf_location_generation_is_consistent()
    {
        $testCodes = ['005.133', '150.19', '320.973', '641.5', '895.621'];

        foreach ($testCodes as $code) {
            $result1 = Book::generateShelfLocation($code);
            $result2 = Book::generateShelfLocation($code);
            $this->assertEquals($result1, $result2, "Classification {$code} should always generate the same shelf location");
        }
    }

    /**
     * Test shelf location format validity
     */
    public function test_shelf_location_format_is_valid()
    {
        $testCodes = ['000', '150', '297.122', '530.12', '895.621'];

        foreach ($testCodes as $code) {
            $result = Book::generateShelfLocation($code);
            if ($result !== null) {
                // Format should be "Rak X-Y" where X is A-J and Y is 1-10
                $this->assertMatchesRegularExpression('/^Rak [A-J]-([1-9]|10)$/', $result, "Shelf location format is invalid for classification {$code}");
            }
        }
    }
}
