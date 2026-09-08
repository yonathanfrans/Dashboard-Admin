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
        Schema::create('trs_portal_berita', function (Blueprint $table) {
            $table->id();
            $table->timestamp('entry_date')->nullable()->useCurrent();
            $table->string('heading', 255);
            $table->string('slug', 255)->unique();
            $table->date('date_news');
            $table->string('jns_file', 20)->nullable();
            $table->enum('flag_kegiatan', ['Y', 'T'])->default('T');
            $table->string('thumbnail_image', 255)->nullable();
            $table->string('large_image', 255)->nullable();
            $table->mediumText('content');
            $table->string('source', 200)->nullable();
            $table->date('show_since')->nullable();
            $table->date('off_from')->nullable();
            $table->string('video_url', 512)->nullable();
            $table->string('video_url_smaller', 512)->nullable();
            $table->integer('counter')->default(0);
            $table->enum('publish', ['Y', 'T'])->default('T');
            $table->integer('id_user')->nullable();

            $table->index(['date_news', 'show_since', 'off_from'], 'trs_portal_berita_date_news_show_since_off_from_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_portal_berita');
    }
};
