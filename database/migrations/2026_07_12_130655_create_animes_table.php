<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {

            $table->id();

            // AniList
            $table->unsignedBigInteger('anilist_id')->unique();

            // Title
            $table->string('romaji_title')->nullable();
            $table->string('english_title')->nullable();
            $table->string('native_title')->nullable();

            // Images
            $table->text('cover_image')->nullable();
            $table->text('banner_image')->nullable();

            // Info
            $table->longText('description')->nullable();

            $table->string('format')->nullable();
            $table->string('status')->nullable();

            $table->integer('episodes')->nullable();
            $table->integer('duration')->nullable();

            $table->string('season')->nullable();
            $table->integer('season_year')->nullable();

            $table->string('country')->nullable();
            $table->string('source')->nullable();

            // Stats
            $table->integer('average_score')->nullable();
            $table->integer('popularity')->nullable();
            $table->integer('favourites')->nullable();

            // Trailer
            $table->string('trailer_site')->nullable();
            $table->string('trailer_id')->nullable();

            // Adult
            $table->boolean('is_adult')->default(false);

            // Sync
            $table->timestamp('synced_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('season_year');
            $table->index('average_score');
            $table->index('popularity');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};