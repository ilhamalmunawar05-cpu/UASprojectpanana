<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (!Schema::hasTable('articles')) {
      Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->nullable()->unique();
        $table->text('content')->nullable();
        $table->text('excerpt')->nullable();
        $table->string('image')->nullable();
        $table->string('thumbnail')->nullable();
        $table->unsignedBigInteger('author_id')->nullable();
        $table->unsignedBigInteger('artwork_id')->nullable();
        $table->string('category')->nullable();
        $table->json('tags')->nullable();
        $table->integer('views')->default(0);
        $table->boolean('is_published')->default(false);
        $table->timestamp('published_at')->nullable();
        $table->timestamps();

        $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        // artwork foreign key optional
      });
    }
  }

  public function down(): void
  {
    Schema::dropIfExists('articles');
  }
};
