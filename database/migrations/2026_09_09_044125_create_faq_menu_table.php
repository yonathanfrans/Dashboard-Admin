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
        Schema::create('faq_menu', function (Blueprint $table) {
            $table->smallIncrements('id_sub');
            $table->string('menu', 50);
            $table->string('sub_menu', 255);
            $table->smallInteger('no_urut');
            $table->char('aktif', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_menu');
    }
};
