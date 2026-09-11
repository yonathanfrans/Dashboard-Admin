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
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('id_sub')->nullable();
            $table->string('jenis', 20);
            $table->text('pertanyaan')->nullable();
            $table->text('jawaban')->nullable();
            $table->string('link', 255)->nullable();
            $table->enum('publish', ['Y', 'T'])->default('T');
            $table->string('note', 255)->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('counter', 255)->default('0');

            $table->foreign('id_sub')->references('id_sub')->on('faq_menu')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
