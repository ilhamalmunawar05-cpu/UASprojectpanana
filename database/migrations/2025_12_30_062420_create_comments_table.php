<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Untuk guest
            $table->string('email')->nullable(); // Untuk guest
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Untuk user login
            $table->text('message');
            $table->foreignId('artwork_id')->nullable()->constrained('artworks')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

