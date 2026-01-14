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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // Kode klasifikasi (contoh: 005.1, 004.6)
            $table->string('name'); // Nama klasifikasi
            $table->text('description')->nullable(); // Deskripsi klasifikasi
            $table->string('parent_code', 20)->nullable(); // Parent classification (untuk hierarchy)
            $table->integer('level')->default(1); // Level hierarchy (1=main, 2=sub, 3=detail)
            $table->timestamps();

            $table->index('code');
            $table->index('parent_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifications');
    }
};
