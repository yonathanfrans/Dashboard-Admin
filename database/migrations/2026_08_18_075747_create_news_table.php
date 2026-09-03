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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_category_id')->constrained('news_categories')->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->longText('content');
            $table->longText('file')->nullable();
            $table->string('sumber');
            $table->enum('status', ['Published', 'Unpublished']);
            $table->date('tgl_publish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};