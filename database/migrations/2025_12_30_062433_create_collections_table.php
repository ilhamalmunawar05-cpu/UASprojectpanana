<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->year('year')->nullable();
            $table->string('origin')->nullable(); // Asal/Periode
            $table->string('material')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('collection_number')->unique()->nullable(); // No. Koleksi
            $table->enum('category', ['lukisan', 'patung', 'tekstil', 'keramik', 'lainnya'])->default('lukisan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};