<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add classification fields to books table
        Schema::table('books', function (Blueprint $table) {
            $table->string('barcode', 50)->unique()->nullable()->after('isbn');
            $table->string('classification_code', 20)->nullable()->after('barcode');
            $table->string('call_number', 50)->nullable()->after('classification_code');
            $table->string('shelf_location', 50)->nullable()->after('call_number');
        });

        // Add classification fields to ebooks table
        Schema::table('ebooks', function (Blueprint $table) {
            $table->string('barcode', 50)->unique()->nullable()->after('isbn');
            $table->string('classification_code', 20)->nullable()->after('barcode');
            $table->string('call_number', 50)->nullable()->after('classification_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['barcode', 'classification_code', 'call_number', 'shelf_location']);
        });

        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropColumn(['barcode', 'classification_code', 'call_number']);
        });
    }
};
