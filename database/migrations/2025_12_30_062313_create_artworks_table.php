<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->year('year')->nullable();
            $table->string('medium')->nullable(); // Oil, Acrylic, Digital, dll
            $table->string('dimensions')->nullable(); // 100x150 cm
            $table->decimal('price', 12, 2)->nullable();
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->enum('status', ['available', 'sold', 'on_display'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
