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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("short_desc");
            $table->longText("content");
            $table->integer("author");
            $table->text("featured_image");
            $table->string("status")->default("DRAFT")->comment("PUBLISH, DRAFT");
            $table->string("published_at")->nullable();
            $table->string("seo_url");
            $table->string("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->string("meta_keyword")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
