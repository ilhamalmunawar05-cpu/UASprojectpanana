<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (Schema::hasTable('articles') && !Schema::hasColumn('articles', 'slug')) {
      Schema::table('articles', function (Blueprint $table) {
        $table->string('slug')->nullable()->unique()->after('title');
      });
    }
  }

  public function down(): void
  {
    if (Schema::hasTable('articles') && Schema::hasColumn('articles', 'slug')) {
      Schema::table('articles', function (Blueprint $table) {
        $table->dropColumn('slug');
      });
    }
  }
};
