<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->nullable()->unique();
                $table->text('content')->nullable();
                $table->text('excerpt')->nullable();
                $table->string('image')->nullable();
                $table->unsignedBigInteger('artwork_id')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('articles', function (Blueprint $table) {
                if (!Schema::hasColumn('articles', 'artwork_id')) {
                    $table->unsignedBigInteger('artwork_id')->nullable();
                } else {
                    $table->unsignedBigInteger('artwork_id')->nullable()->change();
                }
            });
        }
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('artwork_id')->nullable(false)->change();
        });
    }
};
