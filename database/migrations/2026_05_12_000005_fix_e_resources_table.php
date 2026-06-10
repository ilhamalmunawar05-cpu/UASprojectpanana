<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop and recreate e_resources table
        Schema::dropIfExists('e_resources');
        
        Schema::create('e_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['ebook', 'journal', 'research_paper', 'multimedia', 'other'])->default('ebook');
            $table->string('file_path')->nullable();
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Add foreign key constraint
        Schema::table('e_resources', function (Blueprint $table) {
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('e_resources');
    }
};
