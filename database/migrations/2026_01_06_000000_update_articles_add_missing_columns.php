<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (Schema::hasTable('articles')) {
      // Add columns without using Doctrine to avoid requiring doctrine/dbal at runtime
      Schema::table('articles', function (Blueprint $table) {
        if (!Schema::hasColumn('articles', 'thumbnail')) {
          $table->string('thumbnail')->nullable();
        }
        if (!Schema::hasColumn('articles', 'category')) {
          $table->string('category')->nullable();
        }
        if (!Schema::hasColumn('articles', 'tags')) {
          // use json column type; if database doesn't support it, migration may still work
          $table->json('tags')->nullable();
        }
        if (!Schema::hasColumn('articles', 'views')) {
          $table->integer('views')->default(0);
        }
        if (!Schema::hasColumn('articles', 'is_published')) {
          $table->boolean('is_published')->default(false);
        }
        if (!Schema::hasColumn('articles', 'published_at')) {
          $table->timestamp('published_at')->nullable();
        }
        if (!Schema::hasColumn('articles', 'author_id')) {
          $table->unsignedBigInteger('author_id')->nullable();
        }
      });

      // attempt to add foreign key in a separate step; ignore failures
      try {
        Schema::table('articles', function (Blueprint $table) {
          $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
      } catch (\Throwable $e) {
        // ignore - some setups (test DB) may not support adding FK here
      }
    }
  }

  public function down(): void
  {
    if (Schema::hasTable('articles')) {
      Schema::table('articles', function (Blueprint $table) {
        if (Schema::hasColumn('articles', 'published_at')) {
          $table->dropColumn('published_at');
        }
        if (Schema::hasColumn('articles', 'is_published')) {
          $table->dropColumn('is_published');
        }
        if (Schema::hasColumn('articles', 'views')) {
          $table->dropColumn('views');
        }
        if (Schema::hasColumn('articles', 'tags')) {
          $table->dropColumn('tags');
        }
        if (Schema::hasColumn('articles', 'category')) {
          $table->dropColumn('category');
        }
        if (Schema::hasColumn('articles', 'thumbnail')) {
          $table->dropColumn('thumbnail');
        }
        if (Schema::hasColumn('articles', 'author_id')) {
          $table->dropForeign(['author_id']);
          $table->dropColumn('author_id');
        }
      });
    }
  }
};
